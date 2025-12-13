<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mst_cards', function (Blueprint $table) {
            $table->id();

            $table->string('bank_name')->nullable();
            $table->string('card_name')->nullable();

            $table->enum('network_type', ['Visa', 'MasterCard', 'RuPay', 'Amex'])->nullable();
            $table->enum('card_category', ['Credit', 'Debit'])->nullable(); // Credit/Debit
            $table->string('card_tier')->nullable(); // Gold, Platinum, etc

            $table->decimal('joining_fee', 10, 2)->nullable();
            $table->decimal('annual_fee', 10, 2)->nullable();

            $table->text('pros')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mst_cards');
    }
};
