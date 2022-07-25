<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36);
            $table->string('first_name');
            $table->string('last_name');
            $table->tinyInteger('is_admin')->default(0)->comment('1-Yes, 0-No');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar', 36)->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->tinyInteger('is_marketing')->default(0)->comment('1-Yes, 0-No');
            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
