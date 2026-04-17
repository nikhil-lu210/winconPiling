<?php

declare(strict_types=1);

namespace Admin;

final class GalleryController extends \BaseController
{
    public function index(): void
    {
        $this->stub('Gallery');
    }

    public function create(): void
    {
        $this->stub('Gallery create');
    }

    public function store(): void
    {
        $this->response->redirect(\base_url('admin/gallery'));
    }

    public function edit(string $id): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Edit gallery</title></head><body>'
            . '<h1>Gallery #' . \e($id) . '</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }

    public function update(string $id): void
    {
        $this->response->redirect(\base_url('admin/gallery'));
    }

    public function delete(string $id): void
    {
        $this->response->redirect(\base_url('admin/gallery'));
    }

    public function reorder(): void
    {
        $this->response->json(['ok' => true]);
    }

    private function stub(string $title): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>' . \e($title) . '</title></head><body>'
            . '<h1>' . \e($title) . '</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }
}
