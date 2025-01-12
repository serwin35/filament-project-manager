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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('name')->index();
            $table->text('description');
            $table->date('start_date')->index();
            $table->date('end_date')
                ->index()
                ->nullable();

            $table->string('state')->index();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained();
            $table->foreignId('owner_id')
                ->nullable()
                ->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
