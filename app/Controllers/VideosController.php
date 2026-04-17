<?php

declare(strict_types=1);

final class VideosController extends BaseController
{
    public function index(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Videos</title></head><body>'
            . '<h1>Videos</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }
}
