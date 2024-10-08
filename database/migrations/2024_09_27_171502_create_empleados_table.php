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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->bigInteger('identificacion')->unique();
            $table->string('direccion')->nullable();
            $table->bigInteger('telefono')->nullable();
            $table->string('pais')->nullable();
            $table->string('ciudad')->nullable();
            //$table->enum('cargo', ['colaborador', 'jefe', 'presidente']);
            $table->foreignId('jefe_id')->nullable()->constrained('empleados')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
