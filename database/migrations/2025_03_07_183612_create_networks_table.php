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
        Schema::create('networks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained();
            $table->foreignId('cloud_account_id')
                ->constrained();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('networks');
            $table->string('name');
            $table->string('type')->index();
            $table->string('external_id')->nullable();
            $table->jsonb('config');
            $table->timestamps();

            $table->unique(['name', 'external_id', 'organization_id', 'cloud_account_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('networks');
    }
};
