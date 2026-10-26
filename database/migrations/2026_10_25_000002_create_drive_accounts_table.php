<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drive_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('google_credential_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->text('access_token');
            $table->text('refresh_token');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->unique(['google_credential_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drive_accounts');
    }
};
