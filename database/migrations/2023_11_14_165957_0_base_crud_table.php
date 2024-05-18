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
        Schema::create('base_crud', function (Blueprint $table) {
            $table->id();
            $table->integer('column_integer');
            $table->smallInteger('column_smallint')->nullable();
            $table->string('column_string');
            $table->boolean('column_boolean')->nullable();
            $table->float('column_float')->nullable();
            $table->date('column_date')->nullable();
            $table->time('column_time')->nullable();
            $table->dateTime('column_datetime')->nullable();
            $table->text('column_text')->nullable();
            $table->binary('column_binary')->nullable();
            $table->timestamps(); // Laravel timestamps
            $table->softDeletes(); // Soft delete column (deleted_at)

            // Additional audit columns
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Foreign key constraints (assuming you have a users table)
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
           Schema::dropIfExists('base_crud');
    }
};
