<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Course;
use App\Models\Program;
use App\Models\Scholarship;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        User::create([
            'name' => "reyhan",
            'email' => 'reyhan@gmail.com',
            'password' => 'rahasia',
        ]);
       
        User::create([
            'name' => "budi",
            'email' => 'budi@gmail.com',
            'password' => 'rahasia',
        ]);
       
        User::create([
            'name' => "james",
            'email' => 'james@gmail.com',
            'password' => 'rahasia',
        ]);
       
        Scholarship::create([
            'name' => "scholarship A",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Scholarship::create([
            'name' => "scholarship B",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Scholarship::create([
            'name' => "scholarship C",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Program::create([
            'name' => "program A",
            'scholarship_id' => 1,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
            'price' => 1000000
        ]);

        Program::create([
            'name' => "program B",
            'scholarship_id' => 2,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
            'price' => 2000000
        
        ]);

        Program::create([
            'name' => "program C",
            'scholarship_id' => 3,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
            'price' => 3000000
        ]);

        Course::create([
            'name' => 'course A',
        ]);

        Course::create([
            'name' => 'course B',
        ]);

        Course::create([
            'name' => 'course C',
        ]);

        Course::create([
            'name' => 'course D',
        ]);

        Article::create([
            'title' => 'article A',
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article B',
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article C',
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        DB::table('course_program')->insert([
            'course_id' => '1',
            'program_id' => '1',
        ]);

        DB::table('course_program')->insert([
            'program_id' => '1',
            'course_id' => '2',
        ]);

        DB::table('course_program')->insert([
            'program_id' => '2',
            'course_id' => '1',
        ]);
        
        DB::table('course_program')->insert([
            'program_id' => '2',
            'course_id' => '3',
        ]);

        DB::table('course_program')->insert([
            'program_id' => '3',
            'course_id' => '1',
        ]);
        
        DB::table('course_program')->insert([
            'program_id' => '3',
            'course_id' => '4',
        ]);

        Tag::create([
            'name' => 'Tag A',
        ]);

        Tag::create([
            'name' => 'Tag B',
        ]);

        Tag::create([
            'name' => 'Tag C',
        ]);
    }
}
