<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name')->nullable();
            $table->string('prenom')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('adrCL')->nullable();
            $table->string('typeCL')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('NumS')->nullable();
            $table->enum('role',['admin','ingenieur','user'])->default('user');
            $table->enum('status',['active','inactive'])->nullable()->default('active');
            $table->string('nameD')->nullable();
            $table->string('resetP')->unique()->nullable();
            $table->string('emailD')->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
