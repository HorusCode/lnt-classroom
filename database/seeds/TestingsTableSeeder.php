<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class TestingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creatorId = User::whereHas('role', function ($q) {
            $q->where('name', 'teacher');
        })->first()->id;
        $data = [
            [
                'title' => 'Тест 1',
                'creator_id' => $creatorId,
                'questions' => '[{"name":"Вопрос 1","answers":[{"text":"Answer Text1","answer":false},{"text":"Answer Text1","answer":false}]}]',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Тест 2',
                'creator_id' => $creatorId,
                'questions' => '[{"name":"Вопрос 1","answers":[{"text":"Answer Text1","answer":false},{"text":"Answer Text1","answer":false}]}]',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Тест 3',
                'creator_id' => $creatorId,
                'questions' => '[{"name":"Вопрос 1","answers":[{"text":"Answer Text1","answer":false},{"text":"Answer Text1","answer":false}]}]',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]
        ];

        DB::table('testings')->insert($data);
    }
}
