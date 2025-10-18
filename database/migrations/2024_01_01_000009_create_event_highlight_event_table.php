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
        Schema::create('event_highlight_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('highlight_event_id');
            $table->unsignedBigInteger('event_id');
            $table->timestamps();
            
            $table->foreign('highlight_event_id')->references('id')->on('highlight_events')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_highlight_event');
    }
};