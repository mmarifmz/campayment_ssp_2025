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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();

            // Participant Info
            $table->string('nama');
            $table->string('kelas');
            $table->string('jawatan');
            $table->string('ic'); // format: 000000-00-0000
            $table->string('jantina');
            $table->string('agama');

            // Guardian Info
            $table->string('telefon');
            $table->string('email');

            // Health / Allergy
            $table->text('alergik')->nullable();

            // Payment
            $table->unsignedInteger('sumbangan')->nullable(); // in RM
            $table->unsignedInteger('total_amount'); // total in sen
            $table->string('bill_code')->nullable();
            $table->string('bill_ref')->nullable();
            $table->boolean('is_paid')->default(false);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
