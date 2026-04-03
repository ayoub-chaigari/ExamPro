<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->string('type')->default('efm')->after('duration'); // 'efm' or 'examen'
            $table->string('niveau')->nullable()->after('type');       // e.g. Technicien Spécialisé
            $table->string('module_no')->nullable()->after('niveau');  // e.g. M102
            $table->string('bareme')->default('/20')->after('module_no'); // e.g. /20, /40
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['type', 'niveau', 'module_no', 'bareme']);
        });
    }
};
