<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->float('discount_from_retail')->default(30.0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');
        });

        Schema::create('versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('version_id');
            $table->unsignedBigInteger('client_id');
            $table->string('external_uid');
            $table->string('status');
            $table->timestamp('sent_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('version_id')
                ->references('id')
                ->on('versions')
                ->onDelete('cascade');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('version_id');
            $table->string('name');
            $table->float('price')->nullable();
            $table->tinyInteger('enabled')->default(1);
            $table->mediumInteger('rank');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('version_id')
                ->references('id')
                ->on('versions')
                ->onDelete('cascade');
        });

        Schema::create('category_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('version_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->float('price')->nullable();
            $table->string('sku')->nullable();
            $table->tinyInteger('enabled')->default(1);
            $table->mediumInteger('rank');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('version_id')
                ->references('id')
                ->on('versions')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });

        Schema::create('flags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('class_name');
            $table->tinyInteger('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_item_flags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('flag_id');
            $table->unsignedBigInteger('category_item_id');
            $table->timestamps();

            $table->foreign('category_item_id')
                ->references('id')
                ->on('category_items')
                ->onDelete('cascade');

            $table->foreign('flag_id')
                ->references('id')
                ->on('flags')
                ->onDelete('cascade');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('category_item_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('category_item_id')
                ->references('id')
                ->on('category_items')
                ->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('partner_approved')->after('email_verified_at')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['partner_approved']);
            $table->dropSoftDeletes();
        });

        Schema::drop('user_clients');
        Schema::drop('clients');
        Schema::drop('order_items');
        Schema::drop('orders');
        Schema::drop('category_item_flags');
        Schema::drop('flags');
        Schema::drop('category_items');
        Schema::drop('categories');
        Schema::drop('versions');
    }
}
