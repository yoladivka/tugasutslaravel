<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'mahasiswa'])->default('mahasiswa')->after('email');
            $table->string('nim')->nullable()->after('role');
            $table->string('jurusan')->nullable()->after('nim');
            $table->string('semester')->nullable()->after('jurusan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim', 'jurusan', 'semester']);
        });
    }
};