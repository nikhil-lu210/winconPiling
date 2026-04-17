<?php

declare(strict_types=1);

namespace Admin;

final class MessageController extends \BaseController
{
    public function index(): void
    {
        $this->html('Messages');
    }

    public function view(string $id): void
    {
        $this->html('Message ' . $id);
    }

    public function star(string $id): void
    {
        $this->response->redirect(\base_url('admin/messages'));
    }

    public function delete(string $id): void
    {
        $this->response->redirect(\base_url('admin/messages'));
    }

    public function markRead(): void
    {
        $this->response->redirect(\base_url('admin/messages'));
    }

    private function html(string $title): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>' . \e($title) . '</title></head><body>'
            . '<h1>' . \e($title) . '</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }
}
