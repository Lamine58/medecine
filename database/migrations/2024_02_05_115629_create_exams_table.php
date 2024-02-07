<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
     public function up()
     {
         Schema::create('exams', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('type_exam_id');
            $table->uuid('customer_id');
            $table->uuid('business_id');
            $table->text('order')->nullable();
            $table->longtext('card')->nullable();
            $table->longtext('files')->nullable();
            $table->longtext('results')->nullable();
            $table->datetime('date')->nullable();
            $table->string('code');
            $table->uuid('user_id')->nullable();
            $table->timestamps();

            $table->foreign('type_exam_id')->references('id')->on('type_exams')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
             
         });
     }
 
     public function down()
     {
         Schema::dropIfExists('exams');
     }
};
