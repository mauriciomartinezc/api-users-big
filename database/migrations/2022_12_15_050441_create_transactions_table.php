<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_api')
                ->unique()
                ->index();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')
                ->references('id_api')
                ->on('clients');
            $table->unsignedBigInteger('segmentation_id');
            $table->unsignedBigInteger('transaction_type_id');
            $table->unsignedBigInteger('transaction_status_id');
            $table->unsignedBigInteger('transaction_currency_id');
            $table->unsignedBigInteger('transaction_source_id');
            $table->year('year');
            $table->integer('month');
            $table->float('amount', 17, 2);
            $table->date('savings_expiration_date')
                ->nullable();
            $table->longText('transaction_detail')
                ->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
