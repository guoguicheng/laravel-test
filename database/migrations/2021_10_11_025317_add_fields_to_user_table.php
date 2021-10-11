<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUserTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 角色
            $table->integer('role')->default(User::ROLE_STUDENT);
            $table->tinyInteger('enable')->default(User::ENABLE_FALSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'enable']);
        });
    }
}
