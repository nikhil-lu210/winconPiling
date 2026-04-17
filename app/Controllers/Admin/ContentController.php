<?php

declare(strict_types=1);

namespace Admin;

final class ContentController extends AdminBaseController
{
    public function index(): void
    {
        $model = new \PageContentModel();
        $rows = $model->getAll();
        $contentGroups = [];
        foreach ($rows as $row) {
            $page = (string) ($row['page'] ?? '');
            if (!isset($contentGroups[$page])) {
                $contentGroups[$page] = [];
            }
            $contentGroups[$page][] = $row;
        }

        $this->render('admin/content/index', [
            'pageTitle' => 'Page contents',
            'contentGroups' => $contentGroups,
        ]);
    }

    public function edit(string $id): void
    {
        $model = new \PageContentModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }

        $this->render('admin/content/edit', [
            'pageTitle' => 'Edit content',
            'item' => $item,
        ]);
    }

    public function update(string $id): void
    {
        $model = new \PageContentModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }

        if (!$this->request->isPost()) {
            $this->response->redirect(\base_url('admin/content'));
        }

        if (!\array_key_exists('value', $_POST)) {
            \flash('error', 'The value field is required.');
            $this->response->redirect(\base_url('admin/content/edit/' . $id));
        }

        $value = $this->request->postRaw('value');
        $value = \is_string($value) ? $value : '';

        $model->update((int) $id, $value);
        \flash('success', 'Content updated successfully.');
        $this->response->redirect(\base_url('admin/content'));
    }
}
