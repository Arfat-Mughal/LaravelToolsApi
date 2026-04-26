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
        Schema::create('site_smtp_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->string('mailer')->default('smtp');
            $table->text('host')->nullable();
            $table->unsignedInteger('port')->nullable();
            $table->text('username')->nullable();
            $table->text('password')->nullable();
            $table->enum('encryption', ['tls', 'ssl'])->nullable();
            $table->string('from_address')->nullable();
            $table->string('from_name')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->unique('site_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_smtp_configs');
    }
};
