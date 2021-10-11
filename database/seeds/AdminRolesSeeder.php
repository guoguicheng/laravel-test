<?php

use App\Models\AdminRoles;
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
                'id' => AdminRoles::ROLE_SCHOOL, 'slug' => 'School', 'name' => 'school', 'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'id' => AdminRoles::ROLE_TEACHER, 'slug' => 'Teacher', 'name' => 'teacher', 'created_at' => $date,
                'updated_at' => $date
            ],
            [
                'id' => AdminRoles::ROLE_STUDENT, 'slug' => 'Student', 'name' => 'student', 'created_at' => $date,
                'updated_at' => $date
            ],
        ];
        DB::table('admin_roles')->insert($data);
    }
}
