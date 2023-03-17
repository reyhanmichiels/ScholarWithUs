<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\FileController;
use App\Http\Resources\ProgramResource;
use App\Http\Resources\TransactionResource;
use App\Libraries\ApiResponse;
use App\Models\Mentor;
use App\Models\Program;
use App\Models\Scholarship;
use App\Models\TagCost;
use App\Models\TagLevel;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
            User::find($transaction->user_id)->programs()->attach($transaction->program_id);
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
        if (Cache::has('program')) {
            $response = Cache::get('program');
        } else {
            $response = $program->all();
            Cache::put('program', $response, 3600);
        }

        $data = [
            'message' => "Show all program",
            'data' => ProgramResource::collection($response)
        ];

        return ApiResponse::success($data, 200);
    }

    public function show(Program $program)
    {
        $data = [
            'message' => "Show Program id $program->id",
            'data' => new ProgramResource($program)
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'scholarship_id' => 'numeric|required',
            'name' => 'string|required|unique:programs',
            'description' => 'string|required',
            'content' => 'string|required',
            'price' => 'numeric|required',
            'tag_level_id' => 'numeric|required',
            'tag_cost_id' => 'numeric|required',
            'mentor_id' => 'numeric|required',
            'program_picture' => 'required|file'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $mentor = Mentor::find($request->mentor_id);
        if (!$mentor) {
            return ApiResponse::error('Mentor not found', 404);
        }

        $scholar = Scholarship::find($request->scholarship_id);
        if (!$scholar) {
            return ApiResponse::error('Scholar not found', 404);
        }

        $tag_level = TagLevel::find($request->tag_level_id);
        if (!$tag_level) {
            return ApiResponse::error('tag level not found', 404);
        }

        $tag_cost = TagCost::find($request->tag_cost_id);
        if (!$tag_cost) {
            return ApiResponse::error('tag cost not found', 404);
        }

        try {
            $program = new Program;
            $program->scholarship_id = $request->scholarship_id;
            $program->name = $request->name;
            $program->description = $request->description;
            $program->content = $request->content;
            $program->price = $request->price;
            $program->tag_level_id = $request->tag_level_id;
            $program->tag_cost_id = $request->tag_cost_id;
            $program->mentor_id = $request->mentor_id;
            $program->save();

            $image = $request->file('program_picture');
            $data = [
                'file' => $image,
                'file_name' =>  "$program->id." . $image->extension(),
                'file_path' => 'program_picture'
            ];

            $url = FileController::manage($data);

            $program->image = $url;
            $program->save();
            Cache::forget('program');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully created program',
            'data' => new ProgramResource($program)
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Program $program)
    {
        if (!Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:programs,name,' . $program->id,
            'description' => 'string|required',
            'content' => 'string|required',
            'price' => 'numeric|required',
            'tag_level_id' => 'numeric|required',
            'tag_cost_id' => 'numeric|required',
            'mentor_id' => 'numeric|required',
            'program_picture' => 'sometimes|required'

        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $mentor = Mentor::find($request->mentor_id);
        if (!$mentor) {
            return ApiResponse::error('Mentor not found', 404);
        }

        $tag_level = TagLevel::find($request->tag_level_id);
        if (!$tag_level) {
            return ApiResponse::error('tag level not found', 404);
        }

        $tag_cost = TagCost::find($request->tag_cost_id);
        if (!$tag_cost) {
            return ApiResponse::error('tag cost not found', 404);
        }

        if (!empty($request->program_picture)) {
            $image = $request->file('program_picture');
            $data = [
                'file' => $image,
                'file_name' =>  $program->id . "." . $image->extension(),
                'file_path' => '/program_picture',
                'delete_file' => substr($program->image, 8)
            ];

            $url = FileController::manage($data);
        }

        try {
            $program->name = $request->name;
            $program->description = $request->description;
            $program->content = $request->content;
            $program->price = $request->price;
            $program->tag_level_id = $request->tag_level_id;
            $program->tag_cost_id = $request->tag_cost_id;
            $program->mentor_id = $request->mentor_id;
            $program->image = $url ?? $program->image;
            $program->save();
            Cache::forget('program');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully updated program',
            'data' => new ProgramResource($program)
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Program $program)
    {
        if (!Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };
        try {
            Storage::delete(substr($program->image, 8));
            $program->delete();
            Cache::forget('program');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Sucessfully deleted program";

        return ApiResponse::success($data, 200);
    }

    public function showNew(Program $program)
    {
        try {
            $response = $program->orderByDesc('created_at')->take(9)->get();

            $data = [
                'message' => "9 newest program",
                'data' => ProgramResource::collection($response)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function buy(Request $request, Program $program)
    {
        if (User::find(Auth::user()->id)->programs->find($program->id)) {
            return ApiResponse::error("User already have that program", 409);
        }

        if ($program->users->count() == 20) {
            return ApiResponse::error("capacity full", 503);
        }

        $validate = Validator::make($request->all(), [
            'payment_type' => "string|required|in:bca,bni,permata,bri,qris"
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            DB::beginTransaction();

            $transaction = new Transaction;
            $transaction->user_id = Auth::id();
            $transaction->program_id = $program->id;
            $transaction->gross_amount = $program->price;
            $transaction->payment_type = $request->payment_type;
            $transaction->save();

            $key = config('midtrans.server_key');

            $transaction_detail = [
                "order_id" => $transaction->id,
                "gross_amount" => $transaction->gross_amount
            ];

            if ($request->payment_type == 'qris') {
                $response = Http::withBasicAuth($key, " ")->post("https://api.sandbox.midtrans.com/v2/charge", [
                    "payment_type" => "qris",
                    "transaction_details" => $transaction_detail,
                ]);
            } else if ($request->payment_type == 'permata') {
                $response = Http::withBasicAuth($key, "")->post("https://api.sandbox.midtrans.com/v2/charge", [
                    "payment_type" => "bank_transfer",
                    "bank_transfer" => [
                        "bank" => "permata",
                        "recipient_name" => 'BCCFinalProject'
                    ],
                    "transaction_details" => $transaction_detail

                ]);
            } else {
                $response = Http::withBasicAuth($key, " ")->post("https://api.sandbox.midtrans.com/v2/charge", [
                    "payment_type" => "bank_transfer",
                    "transaction_details" => $transaction_detail,
                    "bank_transfer" => [
                        "bank" => $request->payment_type
                    ]
                ]);
            }

            if ($response->failed()) {
                return ApiResponse::error("Transaction Failed", 500);
            }

            if ($response['status_code'] != 201) {
                return ApiResponse::error("Transaction Failed", $response['status_code']);
            }

            if ($request->payment_type == 'qris') {
                $data = [
                    'message' => "Scan QR code",
                    'data' => [
                        'qris' => $response['actions'][0]['url'],
                        'transaction' => new TransactionResource($transaction)
                    ]
                ];
            } else {
                $data = [
                    'message' => "Transfer to VA Number",
                    'data' => [
                        'Virtual_Account_Number' => $response['va_numbers'],
                        'transaction' => new TransactionResource($transaction)
                    ]
                ];
            }

            DB::commit();
            return ApiResponse::success($data, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage(), 500);
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
            'data' => ProgramResource::collection($program->all()->only($id->toArray()))
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
                'data' => ProgramResource::collection($program->all()->only($country->intersect($cost)->intersect($level)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $cost_boolean) {
            $country = $this->tag_country($request, $program);
            $cost = $this->tag_cost($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => ProgramResource::collection($program->all()->only($country->intersect($cost)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $level_boolean) {
            $country = $this->tag_country($request, $program);
            $level = $this->tag_level($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => ProgramResource::collection($program->all()->only($country->intersect($level)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean && $level_boolean) {
            $cost = $this->tag_cost($request, $program);
            $level = $this->tag_level($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => ProgramResource::collection($program->all()->only($cost->intersect($level)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean) {
            $country = $this->tag_country($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => ProgramResource::collection($program->all()->only($country->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean) {
            $cost = $this->tag_cost($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => ProgramResource::collection($program->all()->only($cost->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($level_boolean) {
            $level = $this->tag_level($request, $program);

            $data = [
                'message' => 'Programs after filter',
                'data' => ProgramResource::collection($program->all()->only($level->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        $data = [
            'message' => 'You dont have any filter',
            'data' => ProgramResource::collection($program->all())
        ];
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
