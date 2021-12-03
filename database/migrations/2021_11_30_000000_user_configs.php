<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name', 150);
            $table->string('value', 512);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unique(['user_id', 'name']);
        });

        \Illuminate\Support\Facades\DB::insert("INSERT INTO user_configs (user_id, name, value) SELECT id, 'RECEIVE_EMAIL_WHEN_ORDER_STATUS_CHANGE', '" . \App\Constants\HTMLConst::CHECKBOX_CHECKED . "' FROM users");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_configs');
    }
};
