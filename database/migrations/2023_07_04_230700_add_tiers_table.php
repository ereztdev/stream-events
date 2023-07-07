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
        Schema::create('tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('amount');
            $table->foreignId('currency_id')->constrained('currencies');
            $table->timestamps();
        });

        DB::table('tiers')->insert([
            [
                'name' => 'Tier 1',
                'amount' => '5',
                'currency_id' => 1
            ],
            [
                'name' => 'Tier 2',
                'amount' => '10',
                'currency_id' => 1
            ],
            [
                'name' => 'Tier 3',
                'amount' => '15',
                'currency_id' => 1
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiers');
    }
};
