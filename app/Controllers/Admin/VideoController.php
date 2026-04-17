<?php

declare(strict_types=1);

namespace Admin;

final class VideoController extends AdminBaseController
{
    public function index(): void
    {
        $model = new \VideoModel();
        $items = $model->getAll(false);
        $this->render('admin/videos/index', [
            'pageTitle' => 'Videos',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        $this->render('admin/videos/form', [
            'pageTitle' => 'Add video',
            'item' => null,
            'isEdit' => false,
        ]);
    }

    public function store(): void
    {
        $validator = new \Validator();
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'youtube_id' => trim((string) $this->request->post('youtube_id', '')),
            'category' => (string) $this->request->post('category', ''),
            'description' => (string) $this->request->postRaw('description', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'youtube_id' => 'required|youtube_id',
            'category' => 'required|in:piling,civil,site,equipment',
            'sort_order' => 'numeric',
        ]);

        if (!$ok) {
            \Session::flash('errors', $validator->errors);
            \flash('error', 'Please fix the errors below.');
            $this->response->redirect(\base_url('admin/videos/create'));
        }

        $model = new \VideoModel();
        $thumb = $model->buildThumbnailUrl($data['youtube_id']);
        $model->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'youtube_id' => $data['youtube_id'],
            'category' => $data['category'],
            'thumbnail_url' => $thumb,
            'sort_order' => (int) $data['sort_order'],
            'is_featured' => $this->request->post('is_featured') ? 1 : 0,
            'is_active' => $this->request->post('is_active') ? 1 : 0,
        ]);

        \flash('success', 'Video added.');
        $this->response->redirect(\base_url('admin/videos'));
    }

    public function edit(string $id): void
    {
        $model = new \VideoModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $this->render('admin/videos/form', [
            'pageTitle' => 'Edit video',
            'item' => $item,
            'isEdit' => true,
        ]);
    }

    public function update(string $id): void
    {
        $model = new \VideoModel();
        $existing = $model->getById((int) $id);
        if ($existing === null) {
            $this->abort(404);
        }

        $validator = new \Validator();
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'youtube_id' => trim((string) $this->request->post('youtube_id', '')),
            'category' => (string) $this->request->post('category', ''),
            'description' => (string) $this->request->postRaw('description', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'youtube_id' => 'required|youtube_id',
            'category' => 'required|in:piling,civil,site,equipment',
            'sort_order' => 'numeric',
        ]);

        if (!$ok) {
            \Session::flash('errors', $validator->errors);
            \flash('error', 'Please fix the errors below.');
            $this->response->redirect(\base_url('admin/videos/edit/' . $id));
        }

        $thumb = $model->buildThumbnailUrl($data['youtube_id']);
        $model->update((int) $id, [
            'title' => $data['title'],
            'description' => $data['description'],
            'youtube_id' => $data['youtube_id'],
            'category' => $data['category'],
            'thumbnail_url' => $thumb,
            'sort_order' => (int) $data['sort_order'],
            'is_featured' => $this->request->post('is_featured') ? 1 : 0,
            'is_active' => $this->request->post('is_active') ? 1 : 0,
        ]);

        \flash('success', 'Video updated.');
        $this->response->redirect(\base_url('admin/videos'));
    }

    public function delete(string $id): void
    {
        $model = new \VideoModel();
        if ($model->getById((int) $id) === null) {
            $this->abort(404);
        }
        $model->delete((int) $id);
        \flash('success', 'Video deleted.');
        $this->response->redirect(\base_url('admin/videos'));
    }

    public function reorder(): void
    {
        $raw = $this->request->post('order', '');
        if (!\is_string($raw)) {
            $this->response->json(['success' => false], 400);
        }
        $decoded = \json_decode($raw, true);
        if (!\is_array($decoded)) {
            $this->response->json(['success' => false], 400);
        }
        $model = new \VideoModel();
        $model->updateSortOrder($decoded);
        $this->response->json(['success' => true]);
    }

    public function toggleFeatured(string $id): void
    {
        $model = new \VideoModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $next = ((int) ($item['is_featured'] ?? 0)) === 1 ? 0 : 1;
        $model->update((int) $id, ['is_featured' => $next]);
        $this->redirectBack(\base_url('admin/videos'));
    }

    public function toggleActive(string $id): void
    {
        $model = new \VideoModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $next = ((int) ($item['is_active'] ?? 0)) === 1 ? 0 : 1;
        $model->update((int) $id, ['is_active' => $next]);
        $this->redirectBack(\base_url('admin/videos'));
    }
}
