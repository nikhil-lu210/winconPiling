<?php

declare(strict_types=1);

namespace Admin;

final class VideoController extends \BaseController
{
    public function index(): void
    {
        $this->html('Videos');
    }

    public function create(): void
    {
        $this->html('Video create');
    }

    public function store(): void
    {
        $this->response->redirect(\base_url('admin/videos'));
    }

    public function edit(string $id): void
    {
        $this->html('Video ' . $id);
    }

    public function update(string $id): void
    {
        $this->response->redirect(\base_url('admin/videos'));
    }

    public function delete(string $id): void
    {
        $this->response->redirect(\base_url('admin/videos'));
    }

    private function html(string $title): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>' . \e($title) . '</title></head><body>'
            . '<h1>' . \e($title) . '</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }
}
