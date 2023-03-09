<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Mentor;
use App\Models\Program;
use App\Models\Reply;
use App\Models\Scholarship;
use App\Models\Tag;
use App\Models\TagArticle;
use App\Models\TagCost;
use App\Models\TagCountry;
use App\Models\TagLevel;
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
            'password' => bcrypt('rahasia')
        ]);
       
        User::create([
            'name' => "budi",
            'email' => 'budi@gmail.com',
            'password' => bcrypt('rahasia')
        ]);
       
        User::create([
            'name' => "james",
            'email' => 'james@gmail.com',
            'password' => bcrypt('rahasia')
        ]);

        TagCost::create([
            'name' => 'Fully Funded'
        ]);
       
        TagCost::create([
            'name' => 'Half Funded'
        ]);

        TagLevel::create([
            'name' => 'S1'
        ]);
       
        TagLevel::create([
            'name' => 'S2'
        ]);
       
        TagLevel::create([
            'name' => 'S3'
        ]);
       
        TagCountry::create([
            'name' => "Germany"
        ]);
        
        TagCountry::create([
            'name' => "Korean"
        ]);

        TagCountry::create([
            'name' => "Japan"
        ]);

        TagCountry::create([
            'name' => "English"
        ]);

        TagCountry::create([
            'name' => "USA"
        ]);

        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 1,
            'name' => "scholarship A",
            'scholarship_provider' => "Kemendikbud",
            'open_registration' => "2023-03-05",
            'close_registration' => "2023-04-05"
        ]);

        Scholarship::create([
            'tag_level_id' => 2,
            'tag_cost_id' => 2,
            'name' => "scholarship B",
            'scholarship_provider' => "Kemendikbud",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-10"
        ]);

        Scholarship::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 2,
            'name' => "scholarship C",
            'scholarship_provider' => "Kemendikbud",
            'open_registration' => "2023-03-01",
            'close_registration' => "2023-04-01"
        ]);

        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "scholarship C",
            'scholarship_provider' => "Kemendikbud",
            'open_registration' => "2023-03-01",
            'close_registration' => "2023-04-01"
        ]);

        Scholarship::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'name' => "scholarship C",
            'scholarship_provider' => "Kemendikbud",
            'open_registration' => "2023-03-01",
            'close_registration' => "2023-04-01"
        ]);

        Scholarship::create([
            'tag_level_id' => 2,
            'tag_cost_id' => 2,
            'name' => "scholarship C",
            'scholarship_provider' => "Kemendikbud",
            'open_registration' => "2023-03-01",
            'close_registration' => "2023-04-01"
        ]);

        Mentor::create([
            'name' => 'Mentor A',
            'study_track' => 'Computer Science, Harvard',
            'scholar_history' => 'Sholarship A'
        ]);

        Mentor::create([
            'name' => 'Mentor B',
            'study_track' => 'Computer Science, Cambridge',
            'scholar_history' => 'Sholarship B'
        ]);

        Mentor::create([
            'name' => 'Mentor C',
            'study_track' => 'Computer Science, Stanford',
            'scholar_history' => 'Sholarship A'
        ]);

        Program::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 1,
            'mentor_id' => 1,
            'name' => "program A",
            'scholarship_id' => 1,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
            'price' => 1000000
        ]);

        Program::create([
            'tag_level_id' => 2,
            'tag_cost_id' => 2,
            'mentor_id' => 2,
            'name' => "program B",
            'scholarship_id' => 2,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
            'price' => 2000000
        
        ]);

        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 2,
            'mentor_id' => 3,
            'name' => "program C",
            'scholarship_id' => 3,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
            'price' => 3000000
        ]);

        DB::table('program_tag_country')->insert([
            'program_id' => '1',
            'tag_country_id' => '1',
        ]);

        DB::table('program_tag_country')->insert([
            'program_id' => '2',
            'tag_country_id' => '2',
        ]);

        DB::table('program_tag_country')->insert([
            'program_id' => '2',
            'tag_country_id' => '3',
        ]);

        DB::table('program_tag_country')->insert([
            'program_id' => '3',
            'tag_country_id' => '4',
        ]);

        DB::table('program_tag_country')->insert([
            'program_id' => '3',
            'tag_country_id' => '5',
        ]);

        DB::table('scholarship_tag_country')->insert([
            'scholarship_id' => '1',
            'tag_country_id' => '1',
        ]);

        DB::table('scholarship_tag_country')->insert([
            'scholarship_id' => '2',
            'tag_country_id' => '2',
        ]);

        DB::table('scholarship_tag_country')->insert([
            'scholarship_id' => '2',
            'tag_country_id' => '3',
        ]);

        DB::table('scholarship_tag_country')->insert([
            'scholarship_id' => '3',
            'tag_country_id' => '4',
        ]);

        DB::table('scholarship_tag_country')->insert([
            'scholarship_id' => '3',
            'tag_country_id' => '5',
        ]);


        Course::create([
            'mentor_id' => 1,
            'name' => 'course A'
        ]);

        Course::create([
            'mentor_id' => 2,
            'name' => 'course B'
        ]);

        Course::create([
            'mentor_id' => 3,
            'name' => 'course C'
        ]);

        Course::create([
            'mentor_id' => 4,
            'name' => 'course D'
        ]);

        TagArticle::create([
            'name' => 'Tips dan Trik'
        ]);

        TagArticle::create([
            'name' => 'Inspirasi'
        ]);

        TagArticle::create([
            'name' => 'Pendidikan'
        ]);

        TagArticle::create([
            'name' => 'Kehidupan'
        ]);

        TagArticle::create([
            'name' => 'Wisata'
        ]);

        TagArticle::create([
            'name' => 'Bahasa dan Budaya'
        ]);

        Article::create([
            'title' => 'article A',
            'tag_article_id' => 1,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article B',
            'tag_article_id' => 2,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article C',
            'tag_article_id' => 3,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article D',
            'tag_article_id' => 4,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article E',
            'tag_article_id' => 5,
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article F',
            'tag_article_id' => 6,
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

        DB::table('program_user')->insert([
            'program_id' => 1,
            'user_id' => 1
        ]);

        DB::table('program_user')->insert([
            'program_id' => 2,
            'user_id' => 2
        ]);

        DB::table('program_user')->insert([
            'program_id' => 3,
            'user_id' => 3
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

        Discussion::create([
            'user_id' => 1,
            'title' => 'Discussion A',
            'comment'=> 'lorem ipsum'
        ]);

        Discussion::create([
            'user_id' => 2,
            'title' => 'Discussion B',
            'comment'=> 'lorem ipsum'
        ]);

        Discussion::create([
            'user_id' => 3,
            'title' => 'Discussion C',
            'comment'=> 'lorem ipsum'
        ]);

        Reply::create([
            'user_id' => 3,
            'discussion_id' => 1,
            'comment' => 'lorem'
        ]);

        Reply::create([
            'user_id' => 1,
            'discussion_id' => 2,
            'comment' => 'lorem'
        ]);

        Reply::create([
            'user_id' => 2,
            'discussion_id' => 3,
            'comment' => 'lorem'
        ]);
    }
}
