<?php

declare(strict_types=1);

namespace App\Enums;

enum CloudProvider: string
{
    case AWS = 'aws';
    case GoogleCloud = 'google';
    case DigitalOcean = 'digitalocean';
    case HetznerCloud = 'hetzner';

}
