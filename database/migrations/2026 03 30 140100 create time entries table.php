<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('ticket_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->decimal('hours', 5, 2);
            

            $table->date('date');
            

            $table->text('comment')->nullable();
            
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};