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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            // Links to the user who did the action. If the user is deleted, keep the log but set user_id to null.
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');       // 'created', 'updated', or 'deleted'
            $table->string('model_type');   // Stores the model name (e.g., 'App\Models\Listing')
            $table->unsignedBigInteger('model_id'); // Stores the ID of the affected listing
            $table->text('description');    // A human-readable summary of what happened
            $table->timestamps();           // Automatically tracks the date and time
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
