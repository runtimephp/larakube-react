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
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained();
            $table->foreignId('cloud_account_id')
                ->constrained('cloud_accounts');
            $table->string('name');
            $table->string('slug');
            $table->unsignedTinyInteger('region');
            $table->jsonb('config');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clusters');
    }
};
