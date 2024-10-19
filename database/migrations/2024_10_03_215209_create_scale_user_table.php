<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaleUserTable extends Migration
{
    public function up()
    {
        Schema::create('scale_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scale_id')->constrained('scales')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scale_user');
    }
}
