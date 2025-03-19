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
        Schema::create('landings', function (Blueprint $table) {
            $table->id();
            $table->string('landing_name')->nullable();
            $table->string('subdomain')->unique()->nullable();
            $table->string('subdomain_id')->nullable();
            $table->boolean('is_published')->default(false);
            $table->enum('header_type', ['1', '2', '3', '4'])->default('1');
            $table->json('links')->nullable();
            $table->text('body')->nullable();
            // $table->text('body_json')->nullable();
            $table->enum('footer_type', ['1', '2', '3', '4'])->default('1');
            $table->text('footer_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landings');
    }
};
