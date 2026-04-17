<?php

declare(strict_types=1);

namespace Admin;

final class MessageController extends AdminBaseController
{
    public function index(): void
    {
        $filter = (string) $this->request->get('filter', 'all');
        if (!\in_array($filter, ['all', 'unread', 'starred'], true)) {
            $filter = 'all';
        }

        $model = new \MessageModel();
        $messages = $model->getFiltered($filter);
        $unreadCount = $model->countUnread();
        $starredCount = $model->countStarred();

        $this->render('admin/messages/index', [
            'pageTitle' => 'Messages',
            'messages' => $messages,
            'filter' => $filter,
            'unreadCount' => $unreadCount,
            'starredCount' => $starredCount,
        ]);
    }

    public function view(string $id): void
    {
        $model = new \MessageModel();
        $msg = $model->getById((int) $id);
        if ($msg === null) {
            $this->abort(404);
        }
        $wasUnread = ((int) ($msg['is_read'] ?? 0)) === 0;
        /* Ensures read state when JS is disabled; client also POSTs mark-read when unread */
        $model->markRead((int) $id);
        $msg = $model->getById((int) $id) ?? $msg;

        $this->render('admin/messages/view', [
            'pageTitle' => 'View message',
            'message' => $msg,
            'wasUnread' => $wasUnread,
        ]);
    }

    public function star(string $id): void
    {
        $model = new \MessageModel();
        if ($model->getById((int) $id) === null) {
            $this->abort(404);
        }
        $model->toggleStar((int) $id);
        \flash('success', 'Message updated.');
        $this->redirectBack(\base_url('admin/messages'));
    }

    public function delete(string $id): void
    {
        $model = new \MessageModel();
        if ($model->getById((int) $id) === null) {
            $this->abort(404);
        }
        $model->delete((int) $id);
        \flash('success', 'Message deleted.');
        $this->response->redirect(\base_url('admin/messages'));
    }

    public function deleteBulk(): void
    {
        $ids = $this->request->post('ids');
        if (!\is_array($ids)) {
            $ids = ($ids !== null && $ids !== '') ? [(int) $ids] : [];
        }
        $ids = array_map('intval', $ids);
        $ids = array_filter($ids, static fn (int $i) => $i > 0);
        if ($ids === []) {
            $this->jsonResponse(['success' => false, 'message' => 'No messages selected'], 400);
        }
        $model = new \MessageModel();
        $model->deleteMultiple($ids);
        $this->jsonResponse(['success' => true]);
    }

    public function markRead(): void
    {
        $ids = $this->request->post('ids');
        if (!\is_array($ids)) {
            $ids = ($ids !== null && $ids !== '') ? [(int) $ids] : [];
        }
        $ids = array_map('intval', $ids);
        $ids = array_filter($ids, static fn (int $i) => $i > 0);
        if ($ids === []) {
            $this->jsonResponse(['success' => false, 'message' => 'No messages selected'], 400);
        }
        $model = new \MessageModel();
        $model->markReadMultiple(array_values($ids));
        $this->jsonResponse(['success' => true]);
    }
}
