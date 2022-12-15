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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_api')
                ->unique()
                ->index();
            $table->unsignedBigInteger('segmentation_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('user_id');
            $table->string('netcommerce_id')
                ->nullable();
            $table->string('h2a_token')
                ->nullable();
            $table->string('one_signal_player_id')
                ->nullable();
            $table->longText('firma')
                ->nullable();
            $table->unsignedBigInteger('identification_type_id');
            $table->string('identification_number');
            $table->string('mobile_number');
            $table->string('meta')
                ->nullable();
            $table->string('insitu_code_reference')
                ->nullable();
            $table->date('birth_date')
                ->nullable();
            $table->boolean('active')
                ->default(false);
            $table->boolean('has_updated_info')
                ->default(0);
            $table->string('inactivate_reason')
                ->nullable();
            $table->timestamp('account_lockout_date')
                ->nullable();
            $table->unsignedBigInteger('state_user_id')
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
        Schema::dropIfExists('clients');
    }
};
