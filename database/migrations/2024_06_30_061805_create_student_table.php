<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('stu_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable(); 
            $table->integer('borrow_qty')->default(0);           
            $table->string('status')->default('active'); 
            $table->unsignedBigInteger('year_id');
            $table->foreign('year_id')->references('id')->on('year'); 
            $table->unsignedBigInteger('fac_id');
            $table->foreign('fac_id')->references('id')->on('faculty');                                     
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user'); 
            $table->unsignedBigInteger('gen_id')->nullable();
            $table->foreign('gen_id')->references('id')->on('gender'); 
            $table->timestamps();
        });        
    }
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
