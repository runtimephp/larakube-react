<?php

declare(strict_types=1);

use App\ValueObjects\Hetzner\Label;

test('to array', function (): void {

    $label = new Label(
        'hello',
        'world'
    );

    expect($label->toArray())
        ->toBe(['hello', 'world']);
});
