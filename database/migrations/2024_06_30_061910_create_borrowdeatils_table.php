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
        Schema::create('borrowdeatils', function (Blueprint $table) {
            $table->id();
            $table->date('borrow_date');
            $table->date('return_date')->nullable();
            $table->date('deadline_date');
            $table->unsignedInteger('qty'); // Adjust this line
            // add status and price pelaty
            $table->string('status')->default('Pending');
            $table->decimal('price_penalty', 8, 2)->default(0);
            // Relationships             
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('book');   
            $table->unsignedBigInteger('stu_id');
            $table->foreign('stu_id')->references('id')->on('student');                   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowdeatils');
    }
};
