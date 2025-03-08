<?php

declare(strict_types=1);

namespace App\Enums;

enum Region: string
{
    case Nuremberg = 'eu-central-ng';
    case Falkenstein = 'eu-central-fs';
    case Helsinki = 'eu-north-hel';
    case Singapore = 'ap-southeast-sg';
    case Hillsboro = 'us-west-hb';
    case Ashburn = 'us-east-va';

}
