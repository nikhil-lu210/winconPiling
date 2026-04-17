<?php

declare(strict_types=1);

namespace Admin;

final class LandController extends \BaseController
{
    public function index(): void
    {
        $this->html('Land listings (admin)');
    }

    public function create(): void
    {
        $this->html('Land create');
    }

    public function store(): void
    {
        $this->response->redirect(\base_url('admin/land'));
    }

    public function edit(string $id): void
    {
        $this->html('Land ' . $id);
    }

    public function update(string $id): void
    {
        $this->response->redirect(\base_url('admin/land'));
    }

    public function delete(string $id): void
    {
        $this->response->redirect(\base_url('admin/land'));
    }

    private function html(string $title): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>' . \e($title) . '</title></head><body>'
            . '<h1>' . \e($title) . '</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }
}
