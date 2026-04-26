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
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('subject', 200)->nullable();
            $table->text('message');
            $table->json('fields')->nullable();
            $table->enum('status', ['new', 'read', 'replied', 'spam', 'archived'])->default('new');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('notified_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->text('reply_message')->nullable();
            $table->timestamps();

            $table->index(['site_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
