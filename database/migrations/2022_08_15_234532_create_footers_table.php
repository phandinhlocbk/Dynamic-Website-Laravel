<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nulllable();
            $table->text('short_description')->nulllable();
            $table->string('address')->nulllable();
            $table->string('email')->nulllable();
            $table->string('facebook')->nulllable();
            $table->string('twitter')->nulllable();
            $table->string('copyright')->nulllable();
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
        Schema::dropIfExists('footers');
    }
};
