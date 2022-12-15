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
        Schema::create('synchronization_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('table')
                ->comment('References table in database');
            $table->string('column')
                ->comment('References table column in database');
            $table->string('type')
                ->comment('It can be create, update or any other value');
            $table->string('value')
                ->comment('Value we want to save to reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('synchronization_parameters');
    }
};
