<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Consultation;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Interactive;
use App\Models\Material;
use App\Models\Mentor;
use App\Models\Program;
use App\Models\Reply;
use App\Models\Scholarship;
use App\Models\TagArticle;
use App\Models\TagCost;
use App\Models\TagCountry;
use App\Models\TagDiscussion;
use App\Models\TagLevel;
use App\Models\User;
use App\Models\UserProgress;
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
            'name' => "admin",
            'email' => 'admin@gmail.com',
            'password' => bcrypt('rahasia'),
            'role' => 'admin',
            'image' => '/storage//profile_picture/example.svg'
        ]);

        User::create([
            'name' => "reyhan",
            'email' => 'reyhan@gmail.com',
            'password' => bcrypt('rahasia'),
            'image' => '/storage//profile_picture/example.svg'
        ]);

        User::create([
            'name' => "budi",
            'email' => 'budi@gmail.com',
            'password' => bcrypt('rahasia'),
            'image' => '/storage//profile_picture/example.svg'
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
            'name' => "Australian"
        ]);

        TagCountry::create([
            'name' => "English"
        ]);

        TagCountry::create([
            'name' => "Japan"
        ]);

        TagCountry::create([
            'name' => "Korea"
        ]);

        TagCountry::create([
            'name' => "Turkey"
        ]);

        TagCountry::create([
            'name' => "Russian"
        ]);

        TagCountry::create([
            'name' => "Irland"
        ]);

        Scholarship::create([
            'tag_level_id' => 2,
            'tag_cost_id' => 1,
            'name' => "Australian National University",
            'scholarship_provider' => "AGRTP",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Beasiswa Australian Government Research Training Program (AGRTP) International Fee Offset Scholarship - Australian National University untuk jenjang S2/S3 dengan tipe Fully Funded di Australia',
            'university' => 'Australian National University',
            'study_program' => 'Natural Science, Life Sciences and Technology, Health and Medical Science, Engineering, Humanities and Social Sciences, Arts, Finance and Economics, ICT, Business',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'IELTS, TOEFL iBT, TOEFL PBT, PTE Academic, Duolingo',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Research Proposal, Recomendation Letters, Proof of English Proficiency, Academic Transcript, Evidence of Supervision, Ijazah',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);

        Mentor::create([
            'name' => 'Budi Waseso',
            'study_track' => 'Life Sciences and Technology, Australian National University',
            'scholar_history' => 'Australian National University',
            'image' => '/storage//profile_picture_mentor/example.svg'
        ]);

        Program::create([
            'tag_level_id' => 2,
            'tag_cost_id' => 1,
            'mentor_id' => 1,
            'name' => "Australian National University",
            'scholarship_id' => 1,
            'description' => 'Beasiswa Australian Government Research Training Program (AGRTP) International Fee Offset Scholarship - Australian National University untuk jenjang S2/S3 dengan tipe Fully Funded di Australia',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 2500,
            'image' => "/storage//program_picture/example.svg"
        ]);

        DB::table('program_user')->insert([
            'program_id' => 1,
            'user_id' => 2
        ]);

        DB::table('program_tag_country')->insert([
            'program_id' => '1',
            'tag_country_id' => '1',
        ]);

        DB::table('scholarship_tag_country')->insert([
            'scholarship_id' => '1',
            'tag_country_id' => '1',
        ]);

        Course::create([
            'name' => 'Research Proposal'
        ]);

        Course::create([
            'name' => 'IELTS'
        ]);

        DB::table('course_program')->insert([
            'program_id' => '1',
            'course_id' => '1',
        ]);

        DB::table('course_program')->insert([
            'program_id' => '1',
            'course_id' => '2',
        ]);

        Material::create([
            'course_id' => 1,
            'name' => 'material 1',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 1,
            'name' => 'material 2',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 1,
            'name' => 'material 3',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 2,
            'name' => 'material 1',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 2,
            'name' => 'material 2',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 2,
            'name' => 'material 3',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Interactive::create([
            'program_id' => 1,
            'date' => '2023-03-20',
            'start' => '09:00',
            'finish' => '10:00',
            'zoom' => 'this is link zoom'
        ]);

        Interactive::create([
            'program_id' => 1,
            'date' => '2023-03-27',
            'start' => '09:00',
            'finish' => '10:00',
            'zoom' => 'this is link zoom'
        ]);

        UserProgress::create([
            'user_id' => 2,
            'program_id' => 1,
            'course_id' => 1,
            'material_id' => 1,
        ]);

        UserProgress::create([
            'user_id' => 2,
            'program_id' => 1,
            'course_id' => 1,
            'material_id' => 2,
        ]);


        UserProgress::create([
            'user_id' => 2,
            'program_id' => 1,
            'course_id' => 1,
            'material_id' => 3,
        ]);

        Consultation::create([
            'program_id' => 1,
            'user_id' => 2,
            'type' => 'asking_mentor',
            'date' => '2023-03-19',
            'start' => '09:00',
            'finish' => '10:00',
        ]);

        Scholarship::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'name' => "Monbukagakusho",
            'scholarship_provider' => "GSID",
            'open_registration' => "2023-03-20",
            'close_registration' => "2023-05-31",
            'description' => 'Beasiswa Monbukagakusho (MEXT) Graduate School of International Development (GSID) - Nagoya University untuk jenjang S3 dengan tipe Fully Funded di Jepang',
            'university' => 'Nagoya University',
            'study_program' => 'Humanities and Social Sciences, Finance and Economics, Education, Political Science',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'IELTS, TOEFL iBT, TOEFL PBT, PTE Academic, Duolingo',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Recommendation Letter - Academic, Passport Application Form, Proof of English Proficiency, Master Thesis, Academic Transcript, Field of study and study program, Health Certificate, Publication, Ijazah',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);

        Mentor::create([
            'name' => 'Jerome Sinaga',
            'study_track' => 'Humanities and Social Sciences, Nagoya University',
            'scholar_history' => 'Mombukagakusho',
            'image' => '/storage//profile_picture_mentor/example.svg'
        ]);

        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "Mombukagakusho",
            'scholarship_id' => 1,
            'description' => 'Beasiswa Monbukagakusho (MEXT) Graduate School of International Development (GSID) - Nagoya University untuk jenjang S3 dengan tipe Fully Funded di Jepang',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);

        DB::table('program_user')->insert([
            'program_id' => 2,
            'user_id' => 3
        ]);

        DB::table('program_tag_country')->insert([
            'program_id' => '2',
            'tag_country_id' => '3',
        ]);

        DB::table('scholarship_tag_country')->insert([
            'scholarship_id' => '2',
            'tag_country_id' => '3',
        ]);

        Course::create([
            'name' => 'Research Proposal'
        ]);

        Course::create([
            'name' => 'IELTS'
        ]);


        DB::table('course_program')->insert([
            'program_id' => '2',
            'course_id' => '3',
        ]);

        DB::table('course_program')->insert([
            'program_id' => '2',
            'course_id' => '4',
        ]);

        Material::create([
            'course_id' => 3,
            'name' => 'material 1',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 3,
            'name' => 'material 2',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 3,
            'name' => 'material 3',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 4,
            'name' => 'material 1',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 4,
            'name' => 'material 2',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Material::create([
            'course_id' => 4,
            'name' => 'material 3',
            'modul' => '/storage//material_modul/modul_dummy.pdf',
            'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        ]);

        Interactive::create([
            'program_id' => 2,
            'date' => '2023-03-20',
            'start' => '09:00',
            'finish' => '10:00',
            'zoom' => 'this is link zoom'
        ]);

        Interactive::create([
            'program_id' => 2,
            'date' => '2023-03-27',
            'start' => '09:00',
            'finish' => '10:00',
            'zoom' => 'this is link zoom'
        ]);

        UserProgress::create([
            'user_id' => 3,
            'program_id' => 2,
            'course_id' => 3,
            'material_id' => 7,
        ]);

        UserProgress::create([
            'user_id' => 3,
            'program_id' => 2,
            'course_id' => 3,
            'material_id' => 8,
        ]);


        UserProgress::create([
            'user_id' => 3,
            'program_id' => 2,
            'course_id' => 3,
            'material_id' => 9,
        ]);

        Consultation::create([
            'program_id' => 1,
            'user_id' => 1,
            'type' => 'asking_mentor',
            'date' => '2023-03-20',
            'start' => '09:00',
            'finish' => '10:00',
            'document' => 'this is link document'
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
            'brief_description' => 'Lorem ipsum dolor sit amet consectetur',
            'image' => "/storage//article_picture/example.svg",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article B',
            'tag_article_id' => 2,
            'brief_description' => 'Lorem ipsum dolor sit amet consectetur',
            'image' => "/storage//article_picture/example.svg",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article C',
            'tag_article_id' => 3,
            'brief_description' => 'Lorem ipsum dolor sit amet consectetur',
            'image' => "/storage//article_picture/example.svg",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article D',
            'tag_article_id' => 4,
            'brief_description' => 'Lorem ipsum dolor sit amet consectetur',
            'image' => "/storage//article_picture/example.svg",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article E',
            'tag_article_id' => 5,
            'brief_description' => 'Lorem ipsum dolor sit amet consectetur',
            'image' => "/storage//article_picture/example.svg",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Article::create([
            'title' => 'article F',
            'tag_article_id' => 6,
            'brief_description' => 'Lorem ipsum dolor sit amet consectetur',
            'image' => "/storage//article_picture/example.svg",
            'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?"
        ]);

        Discussion::create([
            'user_id' => 1,
            'title' => 'Discussion A',
            'comment' => 'lorem ipsum'
        ]);

        Discussion::create([
            'user_id' => 2,
            'title' => 'Discussion B',
            'comment' => 'lorem ipsum'
        ]);

        Discussion::create([
            'user_id' => 3,
            'title' => 'Discussion C',
            'comment' => 'lorem ipsum'
        ]);

        TagDiscussion::create([
            'name' => 'php'
        ]);

        TagDiscussion::create([
            'name' => 'java script'
        ]);
        TagDiscussion::create([
            'name' => 'java'
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

        DB::table('discussion_tag_discussion')->insert([
            'discussion_id' => '1',
            'tag_discussion_id' => '2',
        ]);

        DB::table('discussion_tag_discussion')->insert([
            'discussion_id' => '2',
            'tag_discussion_id' => '1',
        ]);

        DB::table('discussion_tag_discussion')->insert([
            'discussion_id' => '2',
            'tag_discussion_id' => '3',
        ]);

        DB::table('discussion_tag_discussion')->insert([
            'discussion_id' => '3',
            'tag_discussion_id' => '2',
        ]);

        DB::table('discussion_tag_discussion')->insert([
            'discussion_id' => '3',
            'tag_discussion_id' => '3',
        ]);


        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "Scholarship A",
            'scholarship_provider' => "lorem",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Lorem Ipsum',
            'university' => 'Lorem Ipsum',
            'study_program' => 'Lorem Ipsum',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'Lorem Ipsum',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Lorem Ipsum',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);
        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "Scholarship A",
            'scholarship_provider' => "lorem",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Lorem Ipsum',
            'university' => 'Lorem Ipsum',
            'study_program' => 'Lorem Ipsum',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'Lorem Ipsum',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Lorem Ipsum',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);
        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "Scholarship A",
            'scholarship_provider' => "lorem",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Lorem Ipsum',
            'university' => 'Lorem Ipsum',
            'study_program' => 'Lorem Ipsum',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'Lorem Ipsum',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Lorem Ipsum',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);
        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "Scholarship A",
            'scholarship_provider' => "lorem",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Lorem Ipsum',
            'university' => 'Lorem Ipsum',
            'study_program' => 'Lorem Ipsum',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'Lorem Ipsum',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Lorem Ipsum',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);
        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "Scholarship A",
            'scholarship_provider' => "lorem",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Lorem Ipsum',
            'university' => 'Lorem Ipsum',
            'study_program' => 'Lorem Ipsum',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'Lorem Ipsum',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Lorem Ipsum',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);
        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "Scholarship A",
            'scholarship_provider' => "lorem",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Lorem Ipsum',
            'university' => 'Lorem Ipsum',
            'study_program' => 'Lorem Ipsum',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'Lorem Ipsum',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Lorem Ipsum',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);
        Scholarship::create([
            'tag_level_id' => 1,
            'tag_cost_id' => 2,
            'name' => "Scholarship A",
            'scholarship_provider' => "lorem",
            'open_registration' => "2023-03-10",
            'close_registration' => "2023-04-15",
            'description' => 'Lorem Ipsum',
            'university' => 'Lorem Ipsum',
            'study_program' => 'Lorem Ipsum',
            'benefit' => 'lorem ipsum',
            'age' => 20,
            'gpa' => 3.50,
            'english_test' => 'Lorem Ipsum',
            // 'other_language_test' => 'lorem ipsum',
            // 'standarized_test' => 'lorem ipsum',
            'documents' => 'Lorem Ipsum',
            'detail_information' => 'this is link',
            'image' => '/storage/scholarship_picture/example.svg'
        ]);
        

        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "lorem",
            'scholarship_id' => 3,
            'description' => 'lorem',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);
        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "lorem",
            'scholarship_id' => 4,
            'description' => 'lorem',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);
        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "lorem",
            'scholarship_id' => 5,
            'description' => 'lorem',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);
        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "lorem",
            'scholarship_id' => 6,
            'description' => 'lorem',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);
        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "lorem",
            'scholarship_id' => 7,
            'description' => 'lorem',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);
        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "lorem",
            'scholarship_id' => 8,
            'description' => 'lorem',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);
        Program::create([
            'tag_level_id' => 3,
            'tag_cost_id' => 1,
            'mentor_id' => 2,
            'name' => "lorem",
            'scholarship_id' => 9,
            'description' => 'lorem',
            'content' => "Modul Pembelajaran, Tanya Mentor, Video Pembelajaran, Review Dokumen, Kelas Interaktif",
            'price' => 1000,
            'image' => "/storage//program_picture/example.svg"
        ]);

        // Scholarship::create([
        //     'tag_level_id' => 2,
        //     'tag_cost_id' => 2,
        //     'name' => "scholarship B",
        //     'scholarship_provider' => "Kemendikbud",
        //     'open_registration' => "2023-03-10",
        //     'close_registration' => "2023-04-10",
        //     'description' => 'lorem ipsum',
        //     'university' => 'lorem ipsum',
        //     'study_program' => 'lorem ipsum',
        //     'benefit' => 'lorem ipsum',
        //     'age' => 20,
        //     'gpa' => 3.40,
        //     'english_test' => 'lorem ipsum',
        //     'other_language_test' => 'lorem ipsum',
        //     'standarized_test' => 'lorem ipsum',
        //     'documents' => 'lorem ipsum',
        //     'detail_information' => 'lorem ipsum',
        //     'image' => '/storage/scholarship_picture/example.svg'
        // ]);

        // Scholarship::create([
        //     'tag_level_id' => 3,
        //     'tag_cost_id' => 2,
        //     'name' => "scholarship C",
        //     'scholarship_provider' => "Kemendikbud",
        //     'open_registration' => "2023-03-01",
        //     'close_registration' => "2023-04-01",
        //     'description' => 'lorem ipsum',
        //     'university' => 'lorem ipsum',
        //     'study_program' => 'lorem ipsum',
        //     'benefit' => 'lorem ipsum',
        //     'age' => 20,
        //     'gpa' => 3.40,
        //     'english_test' => 'lorem ipsum',
        //     'other_language_test' => 'lorem ipsum',
        //     'standarized_test' => 'lorem ipsum',
        //     'documents' => 'lorem ipsum',
        //     'detail_information' => 'lorem ipsum',
        //     'image' => '/storage/scholarship_picture/example.svg'
        // ]);

        // Scholarship::create([
        //     'tag_level_id' => 1,
        //     'tag_cost_id' => 2,
        //     'name' => "scholarship C",
        //     'scholarship_provider' => "Kemendikbud",
        //     'open_registration' => "2023-03-01",
        //     'close_registration' => "2023-04-01",
        //     'description' => 'lorem ipsum',
        //     'university' => 'lorem ipsum',
        //     'study_program' => 'lorem ipsum',
        //     'benefit' => 'lorem ipsum',
        //     'age' => 20,
        //     'gpa' => 3.40,
        //     'english_test' => 'lorem ipsum',
        //     'other_language_test' => 'lorem ipsum',
        //     'standarized_test' => 'lorem ipsum',
        //     'documents' => 'lorem ipsum',
        //     'detail_information' => 'lorem ipsum',
        //     'image' => '/storage/scholarship_picture/example.svg'
        // ]);

        // Scholarship::create([
        //     'tag_level_id' => 3,
        //     'tag_cost_id' => 1,
        //     'name' => "scholarship C",
        //     'scholarship_provider' => "Kemendikbud",
        //     'open_registration' => "2023-03-01",
        //     'close_registration' => "2023-04-01",
        //     'description' => 'lorem ipsum',
        //     'university' => 'lorem ipsum',
        //     'study_program' => 'lorem ipsum',
        //     'benefit' => 'lorem ipsum',
        //     'age' => 20,
        //     'gpa' => 3.40,
        //     'english_test' => 'lorem ipsum',
        //     'other_language_test' => 'lorem ipsum',
        //     'standarized_test' => 'lorem ipsum',
        //     'documents' => 'lorem ipsum',
        //     'detail_information' => 'lorem ipsum',
        //     'image' => '/storage/scholarship_picture/example.svg'
        // ]);

        // Scholarship::create([
        //     'tag_level_id' => 2,
        //     'tag_cost_id' => 2,
        //     'name' => "scholarship C",
        //     'scholarship_provider' => "Kemendikbud",
        //     'open_registration' => "2023-03-01",
        //     'close_registration' => "2023-04-01",
        //     'description' => 'lorem ipsum',
        //     'university' => 'lorem ipsum',
        //     'study_program' => 'lorem ipsum',
        //     'benefit' => 'lorem ipsum',
        //     'age' => 20,
        //     'gpa' => 3.40,
        //     'english_test' => 'lorem ipsum',
        //     'other_language_test' => 'lorem ipsum',
        //     'standarized_test' => 'lorem ipsum',
        //     'documents' => 'lorem ipsum',
        //     'detail_information' => 'lorem ipsum',
        //     'image' => '/storage/scholarship_picture/example.svg'
        // ]);

        // Mentor::create([
        //     'name' => 'Mentor A',
        //     'study_track' => 'Computer Science, Harvard',
        //     'scholar_history' => 'Sholarship A',
        //     'image' => '/storage//profile_picture_mentor/example.svg'
        // ]);

        // Mentor::create([
        //     'name' => 'Mentor B',
        //     'study_track' => 'Computer Science, Cambridge',
        //     'scholar_history' => 'Sholarship B',
        //     'image' => '/storage//profile_picture_mentor/example.svg'
        // ]);

        // Mentor::create([
        //     'name' => 'Mentor C',
        //     'study_track' => 'Computer Science, Stanford',
        //     'scholar_history' => 'Sholarship A',
        //     'image' => '/storage//profile_picture_mentor/example.svg'
        // ]);

        // Program::create([
        //     'tag_level_id' => 1,
        //     'tag_cost_id' => 1,
        //     'mentor_id' => 1,
        //     'name' => "program A",
        //     'scholarship_id' => 1,
        //     'content' => "Content A, Content B, Content C, Content D, Content E",
        //     'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
        //     'price' => 500,
        //     'image' => "/storage//program_picture/example.svg"
        // ]);

        // Program::create([
        //     'tag_level_id' => 2,
        //     'tag_cost_id' => 2,
        //     'mentor_id' => 2,
        //     'name' => "program B",
        //     'content' => "Content A, Content B, Content C, Content D, Content E",
        //     'scholarship_id' => 2,
        //     'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
        //     'price' => 2000000,
        //     'image' => "/storage//program_picture/example.svg"


        // ]);

        // Program::create([
        //     'tag_level_id' => 3,
        //     'tag_cost_id' => 2,
        //     'mentor_id' => 3,
        //     'name' => "program C",
        //     'content' => "Content A, Content B, Content C, Content D, Content E",
        //     'scholarship_id' => 3,
        //     'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi cumque excepturi, officia repellat quas, qui obcaecati, molestias iure ipsum sunt natus fugiat eligendi. Quisquam cupiditate dicta aliquam tenetur excepturi itaque ut amet illo accusamus cumque aut soluta inventore architecto hic assumenda harum, debitis molestiae similique quaerat adipisci ipsa saepe id, ab ratione? Debitis, corrupti minima. Dolor fugiat explicabo expedita repudiandae asperiores harum assumenda impedit amet esse ex, nihil accusantium, molestias aspernatur nisi dolorum! Alias, explicabo incidunt! Ullam deserunt quisquam quibusdam quam iure illum beatae delectus doloribus animi, eos laborum omnis accusamus odit, quos fuga. Ut debitis odio nulla fuga qui?",
        //     'price' => 3000000,
        //     'image' => "/storage//program_picture/example.svg"
        // ]);

        // Interactive::create([
        //     'program_id' => 1,
        //     'date' => '2023-04-18',
        //     'start' => '09:00',
        //     'finish' => '10:00',
        //     'zoom' => 'this is link zoom'
        // ]);

        // Interactive::create([
        //     'program_id' => 1,
        //     'date' => '2023-04-25',
        //     'start' => '09:00',
        //     'finish' => '10:00',
        //     'zoom' => 'this is link zoom'
        // ]);

        // Interactive::create([
        //     'program_id' => 1,
        //     'date' => '2023-05-01',
        //     'start' => '09:00',
        //     'finish' => '10:00',
        //     'zoom' => 'this is link zoom'
        // ]);

        // Consultation::create([
        //     'program_id' => 1,
        //     'user_id' => 1,
        //     'type' => 'asking_mentor',
        //     'date' => '2023-03-19',
        //     'start' => '09:00',
        //     'finish' => '10:00',
        // ]);

        // Consultation::create([
        //     'program_id' => 1,
        //     'user_id' => 1,
        //     'type' => 'asking_mentor',
        //     'date' => '2023-03-20',
        //     'start' => '09:00',
        //     'finish' => '10:00',
        //     'document' => 'this is link document'
        // ]);

        // DB::table('program_tag_country')->insert([
        //     'program_id' => '1',
        //     'tag_country_id' => '1',
        // ]);

        // DB::table('program_tag_country')->insert([
        //     'program_id' => '2',
        //     'tag_country_id' => '2',
        // ]);

        // DB::table('program_tag_country')->insert([
        //     'program_id' => '2',
        //     'tag_country_id' => '3',
        // ]);

        // DB::table('program_tag_country')->insert([
        //     'program_id' => '3',
        //     'tag_country_id' => '4',
        // ]);

        // DB::table('program_tag_country')->insert([
        //     'program_id' => '3',
        //     'tag_country_id' => '5',
        // ]);

        // DB::table('scholarship_tag_country')->insert([
        //     'scholarship_id' => '1',
        //     'tag_country_id' => '1',
        // ]);

        // DB::table('scholarship_tag_country')->insert([
        //     'scholarship_id' => '2',
        //     'tag_country_id' => '2',
        // ]);

        // DB::table('scholarship_tag_country')->insert([
        //     'scholarship_id' => '2',
        //     'tag_country_id' => '3',
        // ]);

        // DB::table('scholarship_tag_country')->insert([
        //     'scholarship_id' => '3',
        //     'tag_country_id' => '4',
        // ]);

        // DB::table('scholarship_tag_country')->insert([
        //     'scholarship_id' => '3',
        //     'tag_country_id' => '5',
        // ]);


        // Course::create([
        //     'mentor_id' => 1,
        //     'name' => 'course A'
        // ]);

        // Course::create([
        //     'mentor_id' => 2,
        //     'name' => 'course B'
        // ]);

        // Course::create([
        //     'mentor_id' => 3,
        //     'name' => 'course C'
        // ]);

        // Course::create([
        //     'mentor_id' => 4,
        //     'name' => 'course D'
        // ]);

        // Material::create([
        //     'course_id' => 1,
        //     'name' => 'material A',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        // ]);

        // Material::create([
        //     'course_id' => 1,
        //     'name' => 'material B',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview ',
        // ]);

        // Material::create([
        //     'course_id' => 2,
        //     'name' => 'material C',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview '
        // ]);

        // Material::create([
        //     'course_id' => 2,
        //     'name' => 'material D',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview '
        // ]);

        // Material::create([
        //     'course_id' => 3,
        //     'name' => 'material E',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview '
        // ]);

        // Material::create([
        //     'course_id' => 3,
        //     'name' => 'material F',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview '
        // ]);

        // Material::create([
        //     'course_id' => 4,
        //     'name' => 'material G',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview '
        // ]);

        // Material::create([
        //     'course_id' => 4,
        //     'name' => 'material H',
        //     'modul' => '/storage//material_modul/modul_dummy.pdf',
        //     'video' => 'https://drive.google.com/file/d/1ZLUzjSkwtxXhjRctYAcsrAxhfMOV8mJC/preview '
        // ]);


        // DB::table('course_program')->insert([
        //     'program_id' => '1',
        //     'course_id' => '1',
        // ]);

        // DB::table('course_program')->insert([
        //     'program_id' => '1',
        //     'course_id' => '2',
        // ]);

        // DB::table('course_program')->insert([
        //     'program_id' => '2',
        //     'course_id' => '1',
        // ]);

        // DB::table('course_program')->insert([
        //     'program_id' => '2',
        //     'course_id' => '3',
        // ]);

        // DB::table('course_program')->insert([
        //     'program_id' => '3',
        //     'course_id' => '1',
        // ]);

        // DB::table('course_program')->insert([
        //     'program_id' => '3',
        //     'course_id' => '4',
        // ]);

        // DB::table('program_user')->insert([
        //     'program_id' => 1,
        //     'user_id' => 1
        // ]);

        // DB::table('program_user')->insert([
        //     'program_id' => 2,
        //     'user_id' => 2
        // ]);

        // DB::table('program_user')->insert([
        //     'program_id' => 3,
        //     'user_id' => 3
        // ]);

        // Tag::create([
        //     'name' => 'Tag A',
        // ]);

        // Tag::create([
        //     'name' => 'Tag B',
        // ]);

        // Tag::create([
        //     'name' => 'Tag C',
        // ]);



        // UserProgress::create([
        //     'user_id' => 1,
        //     'program_id' => 1,
        //     'course_id' => 1,
        //     'material_id' => 1,
        // ]);

        // UserProgress::create([
        //     'user_id' => 1,
        //     'program_id' => 1,
        //     'course_id' => 1,
        //     'material_id' => 2,
        // ]);
    }
}
