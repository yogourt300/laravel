<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            

            $table->foreignId('project_id')
                  ->constrained()
                  ->onDelete('cascade');
            

            $table->integer('included_hours')->default(0);
            

            $table->decimal('extra_hourly_rate', 8, 2)->default(0);
            

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->string('status')->default('actif');
            
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};