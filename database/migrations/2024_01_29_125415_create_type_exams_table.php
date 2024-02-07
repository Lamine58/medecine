<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeExamsTable extends Migration
{
    public function up()
    {
        Schema::create('type_exams', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->decimal('price_xof', 10, 2);
            $table->decimal('price_euro', 10, 2);
            $table->decimal('price_usd', 10, 2);
            $table->uuid('user_id');
            $table->timestamps();

        });
        
    }

    public function down()
    {
        Schema::dropIfExists('type_exams');
    }
}
