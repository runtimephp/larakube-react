<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Response;

final class ClusterController
{
    public function index(): Response
    {
        return inertia('clusters/index');
    }
}
