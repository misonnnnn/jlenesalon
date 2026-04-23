<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->text('excerpt_en')->nullable()->after('name_ja');
            $table->text('excerpt_ja')->nullable()->after('excerpt_en');
        });

        Schema::table('service_menus', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('service_id');
            $table->string('title_ja')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('title_ja');
            $table->text('description_ja')->nullable()->after('description_en');
        });

        DB::table('services')->update([
            'excerpt_en' => DB::raw('excerpt'),
            'excerpt_ja' => DB::raw('excerpt'),
        ]);

        DB::table('service_menus')->update([
            'title_en' => DB::raw('title'),
            'title_ja' => DB::raw('title'),
            'description_en' => DB::raw('description'),
            'description_ja' => DB::raw('description'),
        ]);
    }

    public function down(): void
    {
        Schema::table('service_menus', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_ja', 'description_en', 'description_ja']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['excerpt_en', 'excerpt_ja']);
        });
    }
};
