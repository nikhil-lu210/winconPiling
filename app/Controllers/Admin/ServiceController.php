<?php

declare(strict_types=1);

namespace Admin;

final class ServiceController extends AdminBaseController
{
    public function index(): void
    {
        $model = new \ServiceModel();
        $items = $model->getAll(false);
        $this->render('admin/services/index', [
            'pageTitle' => 'Services',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        $this->render('admin/services/form', [
            'pageTitle' => 'Add service',
            'item' => null,
            'isEdit' => false,
            'subItems' => [],
        ]);
    }

    public function store(): void
    {
        $validator = new \Validator();
        $slug = strtolower(trim((string) $this->request->post('slug', '')));
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'slug' => $slug,
            'short_description' => (string) $this->request->postRaw('short_description', ''),
            'full_description' => (string) $this->request->postRaw('full_description', ''),
            'icon_class' => (string) $this->request->post('icon_class', ''),
            'detail_page_slug' => (string) $this->request->post('detail_page_slug', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'slug' => 'required|slug|max:255',
            'sort_order' => 'numeric',
        ]);

        $model = new \ServiceModel();
        if ($ok && $model->slugExists($data['slug'])) {
            $ok = false;
            $validator->errors['slug'] = 'This slug is already taken.';
        }

        if (!$ok) {
            \Session::flash('errors', $validator->errors);
            \flash('error', 'Please fix the errors below.');
            $this->response->redirect(\base_url('admin/services/create'));
        }

        $subJson = $this->collectSubItemsJson();
        $model->create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'short_description' => $data['short_description'],
            'full_description' => $data['full_description'],
            'icon_class' => $data['icon_class'],
            'sub_items' => $subJson,
            'detail_page_slug' => $data['detail_page_slug'] !== '' ? $data['detail_page_slug'] : null,
            'sort_order' => (int) $data['sort_order'],
            'is_active' => $this->request->post('is_active') ? 1 : 0,
        ]);

        \flash('success', 'Service created.');
        $this->response->redirect(\base_url('admin/services'));
    }

    public function edit(string $id): void
    {
        $model = new \ServiceModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $this->render('admin/services/form', [
            'pageTitle' => 'Edit service',
            'item' => $item,
            'isEdit' => true,
            'subItems' => $model->decodeSubItems($item),
        ]);
    }

    public function update(string $id): void
    {
        $model = new \ServiceModel();
        $existing = $model->getById((int) $id);
        if ($existing === null) {
            $this->abort(404);
        }

        $validator = new \Validator();
        $slug = strtolower(trim((string) $this->request->post('slug', '')));
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'slug' => $slug,
            'short_description' => (string) $this->request->postRaw('short_description', ''),
            'full_description' => (string) $this->request->postRaw('full_description', ''),
            'icon_class' => (string) $this->request->post('icon_class', ''),
            'detail_page_slug' => (string) $this->request->post('detail_page_slug', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'slug' => 'required|slug|max:255',
            'sort_order' => 'numeric',
        ]);

        if ($ok && $model->slugExists($data['slug'], (int) $id)) {
            $ok = false;
            $validator->errors['slug'] = 'This slug is already taken.';
        }

        if (!$ok) {
            \Session::flash('errors', $validator->errors);
            \flash('error', 'Please fix the errors below.');
            $this->response->redirect(\base_url('admin/services/edit/' . $id));
        }

        $subJson = $this->collectSubItemsJson();
        $model->update((int) $id, [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'short_description' => $data['short_description'],
            'full_description' => $data['full_description'],
            'icon_class' => $data['icon_class'],
            'sub_items' => $subJson,
            'detail_page_slug' => $data['detail_page_slug'] !== '' ? $data['detail_page_slug'] : null,
            'sort_order' => (int) $data['sort_order'],
            'is_active' => $this->request->post('is_active') ? 1 : 0,
        ]);

        \flash('success', 'Service updated.');
        $this->response->redirect(\base_url('admin/services'));
    }

    public function delete(string $id): void
    {
        $model = new \ServiceModel();
        if ($model->getById((int) $id) === null) {
            $this->abort(404);
        }
        $model->delete((int) $id);
        \flash('success', 'Service deleted.');
        $this->response->redirect(\base_url('admin/services'));
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
        $model = new \ServiceModel();
        $model->updateSortOrder($decoded);
        $this->response->json(['success' => true]);
    }

    public function toggleActive(string $id): void
    {
        $model = new \ServiceModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $next = ((int) ($item['is_active'] ?? 0)) === 1 ? 0 : 1;
        $model->update((int) $id, ['is_active' => $next]);
        $this->redirectBack(\base_url('admin/services'));
    }

    private function collectSubItemsJson(): string
    {
        $raw = $this->request->post('sub_items');
        if (!\is_array($raw)) {
            return '[]';
        }
        $list = [];
        foreach ($raw as $line) {
            if (\is_string($line) && trim($line) !== '') {
                $list[] = trim($line);
            }
        }
        return \json_encode($list, \JSON_UNESCAPED_UNICODE);
    }
}
