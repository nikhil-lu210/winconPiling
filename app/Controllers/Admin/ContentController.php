<?php

declare(strict_types=1);

namespace Admin;

final class ContentController extends \BaseController
{
    public function index(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Content</title></head><body>'
            . '<h1>Content</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }

    public function edit(string $id): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Edit content</title></head><body>'
            . '<h1>Edit content #' . \e($id) . '</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }

    public function update(string $id): void
    {
        $this->response->redirect(\base_url('admin/content'));
    }
}
