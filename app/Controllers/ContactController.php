<?php

declare(strict_types=1);

final class ContactController extends BaseController
{
    public function index(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Contact</title></head><body>'
            . '<h1>Contact</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }

    public function send(): void
    {
        $this->response->redirect(base_url('contact'));
    }
}
