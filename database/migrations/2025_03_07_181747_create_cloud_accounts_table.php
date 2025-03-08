<?php

declare(strict_types=1);

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
        Schema::create('cloud_accounts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained();
            $table->string('provider');
            $table->string('name');
            $table->jsonb('config');
            $table->timestamps();

            $table->unique(['organization_id', 'provider', 'name']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloud_providers');
    }
};
