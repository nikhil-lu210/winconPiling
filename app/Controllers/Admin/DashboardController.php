<?php

declare(strict_types=1);

namespace Admin;

final class DashboardController extends \BaseController
{
    public function index(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Dashboard</title></head><body>'
            . '<h1>Dashboard</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }
}
