<?php

declare(strict_types=1);

namespace App\Enums;

enum NetworkResource: string
{
    case Network = 'network';
    case Subnet = 'subnet';
    case Route = 'route';
    case Firewall = 'firewall';
    case FloatingIp = 'floating_ip';
    case IPV4 = 'ipv4';
    case IPV6 = 'ipv6';
    case Switch = 'switch';
    case VSwitch = 'vswitch';

}
