<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'ketua_bem', 'ketua_ukm'])->default('ketua_ukm')->after('email');
            $table->foreignId('ormawa_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ormawa_id']);
            $table->dropColumn(['role', 'ormawa_id', 'phone', 'avatar', 'is_active']);
        });
    }
};
