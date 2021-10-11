<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenuSeeder extends Seeder
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
                'parent_id' => 0, 'order' => 0, 'title' => 'Users', 'icon' => 'fa-users', 'uri' => 'users',
                'created_at' => $date, 'updated_at' => $date
            ],
        ];
        DB::table('admin_menu')->insert($data);
    }
}
