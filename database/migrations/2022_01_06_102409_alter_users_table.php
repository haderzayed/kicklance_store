<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->string('username')->nullable()->unique()->after('email_verified_at');
             $table->string('phone')->nullable()->unique()->after('username')->unique();
             $table->foreignId('current_team_id')->nullable()->after('remember_token');
             $table->string('profile_photo_path', 2048)->nullable()->after('remember_token');
             $table->enum('type',['user','admin','super_admin'])->after('profile_photo_path')
                    ->default('user');
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
               $table->dropColumn('username');
               $table->dropColumn('current_team_id');
               $table->dropColumn('profile_photo_path');
               $table->dropColumn('type');
               $table->dropColumn('phone');
        });
    }
}
