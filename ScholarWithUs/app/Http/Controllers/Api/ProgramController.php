<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Program;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    public function __invoke(Request $request)
    {
        $response = $request->all();

        $signature = hash('sha512', $response['order_id'] . $response['status_code'] . $response['gross_amount'] . config('midtrans.server_key'));

        if ($response['signature_key'] != $signature) {
            return ApiResponse::error('invalid signature key', 400);
        }

        $transaction = Transaction::find($response['order_id']);

        if (!$transaction) {
            $transaction->status = "Not Found ";
            return ApiResponse::error('transaction not found', 400);
        }

        if ($response['transaction_status'] == "settlement") {
            $transaction->status = "PAID";
            $transaction->save();
        } else if ($response['transaction_status'] == "expire") {
            $transaction->status = "CANCELED";
            $transaction->save();
        }

        $data = [
            'message' => 'succesed'
        ];

        return ApiResponse::success($data, 200);
    }

    public function index(Program $program)
    {
        try {
            $data = [
                'message' => "Get all program",
                'data' => $program->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Program $program)
    {
        try {
            $data = [
                'message' => "Program with id $program->id",
                'data' => $program
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'scholarship_id' => 'int|required',
            'name' => 'string|required|unique:programs',
            'description' => 'string|required',
            'price' => 'int|required'

        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $program = new Program;
            $program->scholarship_id = $request->scholarship_id;
            $program->name = $request->name;
            $program->description = $request->description;
            $program->price = $request->price;
            $program->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Program created',
            'data' => $program
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Program $program)
    {
        $validate = Validator::make($request->all(), [
            'scholarship_id' => 'int|required',
            'name' => 'string|required|unique:programs,name,' . $program->id,
            'description' => 'string|required',
            'price' => 'int|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $program->scholarship_id = $request->scholarship_id;
            $program->name = $request->name;
            $program->description = $request->description;
            $program->price = $request->price;
            $program->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Program updated',
            'data' => $program
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Program $program)
    {
        try {
            $program->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data['message'] = "Program Deleted";

        return ApiResponse::success($data, 200);
    }

    public function showNew(Program $program)
    {
        try {
            $response = $program->all()->sortByDesc('created_at')->take(9);

            $data = [
                'message' => "9 newest program",
                'data' => $response
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function buy(Request $request, Program $program)
    {
        $validate = Validator::make($request->all(), [
            'bank' => "string|required"
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            DB::beginTransaction();

            $transaction = new Transaction();
            $transaction->user_id = Auth::id();
            $transaction->program_id = $program->id;
            $transaction->gross_amount = $program->price;
            $transaction->bank = $request->bank;
            $transaction->save();

            $key = config('midtrans.server_key');

            $transaction_detail = [
                "order_id" => $transaction->order_id,
                "gross_amount" => $transaction->gross_amount
            ];

            $response = Http::withBasicAuth($key, " ")->post("https://api.sandbox.midtrans.com/v2/charge", [
                "payment_type" => "bank_transfer",
                "transaction_details" => $transaction_detail,
                "bank_transfer" => [
                    "bank" => $request->bank
                ]
            ]);

            if ($response->failed()) {
                return ApiResponse::error("Transaction Failed", 400);
            }

            if ($response['status_code'] != 201) {
                return ApiResponse::error("Transaction Failed", $response['status_code']);
            }

            $data = [
                'message' => "Transfer to VA Number",
                'data' => $response['va_numbers']
            ];

            DB::commit();

            return ApiResponse::success($data, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }
    }

    public function searchByName(Request $request, Program $program)
    {
        $validate = Validator::make($request->all(), [
            'name' => "string|required"
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $id = collect();

        foreach ($program->all() as $p) {
            $name = strtolower($p->name);
            $nameFromUser = strtolower($request->name);

            if (str_contains($name, $nameFromUser)) {
                $id->push($p->id);
            }
        }

        $data = [
            'message' => "Search Successed",
            'data' => $program->all()->only($id->toArray())
        ];

        return ApiResponse::success($data, 200);
    }

    public function filterByTag(Request $request, Program $program)
    {
        $validate = Validator::make($request->all(), [
            'tag_country_id' => "int",
            'tag_cost_id' => "int",
            'tag_level_id' => "int"
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $country_boolean = $request->tag_country_id;
        $cost_boolean = $request->tag_cost_id;
        $level_boolean = $request->tag_level_id;

        if ($country_boolean && $cost_boolean && $level_boolean) {
            $country = $this->tag_country($request, $program);
            $cost = $this->tag_cost($request, $program);
            $level = $this->tag_level($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => $program->all()->only($country->intersect($cost)->intersect($level)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $cost_boolean) {
            $country = $this->tag_country($request, $program);
            $cost = $this->tag_cost($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => $program->all()->only($country->intersect($cost)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $level_boolean) {
            $country = $this->tag_country($request, $program);
            $level = $this->tag_level($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => $program->all()->only($country->intersect($level)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean && $level_boolean) {
            $cost = $this->tag_cost($request, $program);
            $level = $this->tag_level($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => $program->all()->only($cost->intersect($level)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean) {
            $country = $this->tag_country($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => $program->all()->only($country->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean) {
            $cost = $this->tag_cost($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => $program->all()->only($cost->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($level_boolean) {
            $level = $this->tag_level($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => $program->all()->only($level->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        $data = [
            'message' => 'You dont have any filter',
            'data' => $program->all()
        ];
        return ApiResponse::success($data, 200);
    }

    public function seeTag(Program $program)
    {
        try {
            $data = [
                'message' => "Tag for program with id $program->id",
                'data' => [
                    'tag_level' => [
                        'id' => $program->tag_level_id,
                        'name' => $program->tagLevels->name,
                    ],
                    'tag_cost' => [
                        'id' => $program->tag_cost_id,
                        'name' => $program->tagCosts->name,
                    ],
                    'tag_country' => $program->tagCountries
                ]
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }

    private function tag_level($request, $program)
    {
        $response = $program->where('tag_level_id', $request->tag_level_id)->get('id');
        return $response->pluck('id');
    }

    private function tag_cost($request, $program)
    {
        $response = $program->where('tag_cost_id', $request->tag_cost_id)->get('id');
        return $response->pluck('id');
    }

    private function tag_country($request, $program)
    {
        $country = collect();
        foreach ($program->all() as $pro) {

            foreach ($pro->tagCountries as $tag) {

                if ($tag->pivot->tag_country_id == $request->tag_country_id) {
                    $country->push($tag->pivot->program_id);
                }
            }
        }

        return $country;
    }
}
