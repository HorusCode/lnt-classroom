<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $students = User::whereHas('role', function ($q) {
            $q->where('name', 'student');
        })->get();
        $groups = Group::where('id' ,'>' ,0)->pluck('id')->toArray();
        foreach ($students as $student) {
            $randIndex = array_rand($groups);
            $data[] = [
                'user_id' => $student->id,
                'group_id' => $groups[$randIndex],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('students')->insert($data);
    }
}
