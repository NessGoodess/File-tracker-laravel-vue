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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('reference_number', 100)->unique()->nullable()->after('title');
            $table->unsignedBigInteger('source_department')->nullable()->after('status_id');
            $table->unsignedBigInteger('destination_department')->nullable()->after('source_department');
            $table->date('issue_date')->nullable()->after('destination_department');
            $table->enum('priority', ['None','Low', 'Medium', 'High'])->default('None')->after('issue_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            //
        });
    }
};
