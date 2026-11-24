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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'login')) {
                $table->string('login')->after('name');
            }
            if (! Schema::hasColumn('users', 'FIO')) {
                $table->string('FIO')->after('login');
            }
            if (! Schema::hasColumn('users', 'number')) {
                $table->string('number')->after('FIO');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['user', 'admin'])->default('user')->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login', 'FIO', 'number', 'role']);
        });
    }
};
