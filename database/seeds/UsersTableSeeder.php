<?php

use App\Models\Role;
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
        $roles = Role::all();
        $data = [
            [
                'firstname' => 'student1',
                'lastname' => 'student1',
                'patronymic' => 'student1',
                'phone' => '89061220846',
                'email' => 'student1@mail.ru',
                'role_id' => $roles->where('name','=','student')->pluck('id')->first(),
                'password' => Hash::make('1234'),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'firstname' => 'student2',
                'lastname' => 'student2',
                'patronymic' => 'student2',
                'phone' => '89061220844',
                'email' => 'student2@mail.ru',
                'role_id' => $roles->where('name','=','student')->pluck('id')->first(),
                'password' => Hash::make('1234'),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'firstname' => 'student3',
                'lastname' => 'student3',
                'patronymic' => 'student3',
                'phone' => '89061220843',
                'email' => 'student3@mail.ru',
                'role_id' => $roles->where('name','=','student')->pluck('id')->first(),
                'password' => Hash::make('1234'),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'firstname' => 'teacher',
                'lastname' => 'teacher',
                'patronymic' => 'teacher',
                'phone' => '89061220846',
                'email' => 'teacher@mail.ru',
                'role_id' => $roles->where('name','=','teacher')->pluck('id')->first(),
                'password' => Hash::make('1234'),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'firstname' => 'admin',
                'lastname' => 'admin',
                'patronymic' => 'admin',
                'phone' => '89061220846',
                'email' => 'admin@mail.ru',
                'role_id' => $roles->where('name','=','admin')->pluck('id')->first(),
                'password' => Hash::make('1234'),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]
        ];

        DB::table('users')->insert($data);
    }
}
