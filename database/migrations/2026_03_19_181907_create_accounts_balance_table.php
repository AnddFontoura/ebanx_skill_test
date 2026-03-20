<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts_balance', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('account_id');
            $table->integer('type');
            $table->float('amount', 10, 4);
            $table->softDeletes();

            $table->foreign('account_id')
                ->references('id')
                ->on('account');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_balance');
    }
};
