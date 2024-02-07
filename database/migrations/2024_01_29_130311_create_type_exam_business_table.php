<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeExamBusinessTable extends Migration
{
    public function up()
    {
        Schema::create('type_exam_businesses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('type_exam_id');
            $table->uuid('business_id');
            $table->text('availability');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('type_exam_id')->references('id')->on('type_exams')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_exam_business');
    }
}
