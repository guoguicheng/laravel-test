<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s', time());
        $data = [
            [
                'id' => User::ROLE_SCHOOL, 'slug' => 'School', 'name' => 'school', 'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'id' => User::ROLE_TEACHER, 'slug' => 'Teacher', 'name' => 'teacher', 'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'id' => User::ROLE_STUDENT, 'slug' => 'Student', 'name' => 'student', 'created_at' => $date,
                'updated_at' => $date
            ],
        ];
        DB::table('admin_roles')->insert($data);
    }
}
