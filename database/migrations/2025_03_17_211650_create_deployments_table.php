<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deployments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('cluster_id')->constrained();
            $table->string('status')->default('pending');
            $table->json('metadata')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('deployment_step_groups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('deployment_id')->constrained();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('order');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('deployment_steps', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('deployment_step_group_id')->constrained();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('order');
            $table->string('status')->default('pending');
            $table->json('metadata')->nullable();
            $table->json('output')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }
};
