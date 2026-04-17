<?php

declare(strict_types=1);

final class ServicesController extends BaseController
{
    public function index(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Services</title></head><body>'
            . '<h1>Services</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }

    public function piling(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Deep Piling</title></head><body>'
            . '<h1>Deep Piling</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }
}
