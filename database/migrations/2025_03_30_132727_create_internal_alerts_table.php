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
        Schema::create('internal_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // info, warning, critical
            $table->string('source'); // e.g., superadmin, system
            $table->string('model')->nullable(); // e.g., Tenant
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_alerts');
    }
};
