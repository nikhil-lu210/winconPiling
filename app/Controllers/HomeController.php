<?php

declare(strict_types=1);

final class HomeController extends BaseController
{
    public function index(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Wincon Pilling — Home</title>'
            . '<link rel="stylesheet" href="' . e(asset('css/app.css')) . '"></head><body>'
            . '<h1>Wincon Pilling Construction</h1><p>Phase 1 scaffold — home route OK.</p></body></html>'
        );
    }
}
