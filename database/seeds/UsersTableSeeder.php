<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //Create 3 users for 3 roles: student(user), teacher(admin), admin(superadmin)
        $data = [
            [
                'firstname' => 'student',
                'lastname' => 'student',
                'patronymic' => 'student',
                'phone' => '89061220846',
                'email' => 'student@mail.ru',
                'role_id' => 1,
                'password' => Hash::make('1234')
            ],
            [
                'firstname' => 'teacher',
                'lastname' => 'teacher',
                'patronymic' => 'teacher',
                'phone' => '89061220846',
                'email' => 'teacher@mail.ru',
                'role_id' => 2,
                'password' => Hash::make('1234')
            ],
            [
                'firstname' => 'admin',
                'lastname' => 'admin',
                'patronymic' => 'admin',
                'phone' => '89061220846',
                'email' => 'admin@mail.ru',
                'role_id' => 3,
                'password' => Hash::make('1234')
            ]
        ];

        DB::table('users')->insert($data);
    }
}
