<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('iso_4217');
            $table->string('name');
            $table->string('symbol');
            $table->timestamps();
        });

        DB::table('currencies')->insert([
            [
                'iso_4217' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$'
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
