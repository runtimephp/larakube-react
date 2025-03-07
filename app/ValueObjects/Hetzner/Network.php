<?php

declare(strict_types=1);

namespace App\ValueObjects\Hetzner;

use function array_map;

final readonly class Network
{
    /**
     * @param  array<int, Label>  $labels
     * @param  array<int, Route>  $routes
     * @param  array<int, Subnet>  $subnets
     */
    public function __construct(
        public string $name,
        public string $ip_range,
        public ?array $labels = null,
        public ?array $routes = null,
        public ?array $subnets = null,
        public bool $expose_routes_to_vswitch = false
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'ip_range' => $this->ip_range,
            'expose_routes_to_vswitch' => $this->expose_routes_to_vswitch,
        ];

        // Process labels into an associative array
        if ($this->labels !== null) {
            $labelsArray = [];
            foreach ($this->labels as $label) {
                $labelsArray[$label->key] = $label->value;
            }
            $data['labels'] = $labelsArray;
        }

        // Process routes
        if ($this->routes !== null) {
            $data['routes'] = array_map(fn (Route $route): array => $route->toArray(), $this->routes);
        }

        // Process subnets
        if ($this->subnets !== null) {
            $data['subnets'] = array_map(fn (Subnet $subnet): array => $subnet->toArray(), $this->subnets);
        }

        return $data;
    }
}
