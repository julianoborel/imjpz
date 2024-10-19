<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeUserTable extends Migration
{
    public function up()
    {
        Schema::create('attribute_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('attribute_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');

            $table->primary(['user_id', 'attribute_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attribute_user');
    }
}
