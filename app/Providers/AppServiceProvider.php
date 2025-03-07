<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\Hetzner\CreateNetworkCommand;
use App\Console\Hetzner\CreateServerCommand;
use App\Console\Hetzner\CreateSSHKeyCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureModels();
        $this->configureCommands();
        $this->configureJsonResources();
        $this->configureVite();
        $this->configureCommands();
    }

    private function configureVite(): void
    {
        Vite::prefetch(concurrency: 3);
    }

    private function configureJsonResources(): void
    {
        JsonResource::withoutWrapping();
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );

        $this->commands([
            CreateNetworkCommand::class,
            CreateSSHKeyCommand::class,
            CreateServerCommand::class,
        ]);

    }

    private function configureModels(): void
    {
        Model::unguard();
        Model::shouldBeStrict();
        Model::preventLazyLoading(! $this->app->isProduction());
    }
}
