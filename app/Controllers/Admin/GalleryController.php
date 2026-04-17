<?php

declare(strict_types=1);

namespace Admin;

final class GalleryController extends AdminBaseController
{
    public function index(): void
    {
        $model = new \GalleryModel();
        $items = $model->getAll(false);
        $this->render('admin/gallery/index', [
            'pageTitle' => 'Gallery',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        $this->render('admin/gallery/form', [
            'pageTitle' => 'Add gallery item',
            'item' => null,
            'isEdit' => false,
        ]);
    }

    public function store(): void
    {
        $validator = new \Validator();
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'category' => (string) $this->request->post('category', ''),
            'alt_text' => (string) $this->request->post('alt_text', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
            'description' => (string) $this->request->postRaw('description', ''),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'category' => 'required|in:piling,civil,infrastructure,real_estate',
            'alt_text' => 'max:255',
            'sort_order' => 'numeric',
        ]);

        $file = $this->request->files('image');
        if (!\is_array($file) || (int) ($file['error'] ?? \UPLOAD_ERR_NO_FILE) !== \UPLOAD_ERR_OK) {
            $ok = false;
            $validator->errors['image'] = 'Please upload an image (.jpg, .png, or .webp, max 5MB).';
        }

        if (!$ok) {
            \Session::flash('errors', $validator->errors);
            \flash('error', 'Please fix the errors below.');
            $this->response->redirect(\base_url('admin/gallery/create'));
        }

        $upload = new \FileUpload();
        $dest = \ROOT_PATH . '/public/assets/uploads/gallery/';
        $rel = $upload->handle($file, $dest, [
            'maxSize' => 5 * 1024 * 1024,
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/webp'],
            'prefix' => 'gallery_',
        ]);
        if ($rel === false) {
            \flash('error', 'Image upload failed. Use JPG, PNG, or WebP up to 5MB.');
            $this->response->redirect(\base_url('admin/gallery/create'));
        }

        $model = new \GalleryModel();
        $model->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'image_path' => $rel,
            'alt_text' => $data['alt_text'],
            'sort_order' => (int) $data['sort_order'],
            'is_featured' => $this->request->post('is_featured') ? 1 : 0,
            'is_active' => $this->request->post('is_active') ? 1 : 0,
        ]);

        \flash('success', 'Gallery item added.');
        $this->response->redirect(\base_url('admin/gallery'));
    }

    public function edit(string $id): void
    {
        $model = new \GalleryModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $this->render('admin/gallery/form', [
            'pageTitle' => 'Edit gallery item',
            'item' => $item,
            'isEdit' => true,
        ]);
    }

    public function update(string $id): void
    {
        $model = new \GalleryModel();
        $existing = $model->getById((int) $id);
        if ($existing === null) {
            $this->abort(404);
        }

        $validator = new \Validator();
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'category' => (string) $this->request->post('category', ''),
            'alt_text' => (string) $this->request->post('alt_text', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
            'description' => (string) $this->request->postRaw('description', ''),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'category' => 'required|in:piling,civil,infrastructure,real_estate',
            'alt_text' => 'max:255',
            'sort_order' => 'numeric',
        ]);

        if (!$ok) {
            \Session::flash('errors', $validator->errors);
            \flash('error', 'Please fix the errors below.');
            $this->response->redirect(\base_url('admin/gallery/edit/' . $id));
        }

        $update = [
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'alt_text' => $data['alt_text'],
            'sort_order' => (int) $data['sort_order'],
            'is_featured' => $this->request->post('is_featured') ? 1 : 0,
            'is_active' => $this->request->post('is_active') ? 1 : 0,
        ];

        $file = $this->request->files('image');
        if (\is_array($file) && (int) ($file['error'] ?? \UPLOAD_ERR_NO_FILE) === \UPLOAD_ERR_OK) {
            $upload = new \FileUpload();
            $dest = \ROOT_PATH . '/public/assets/uploads/gallery/';
            $rel = $upload->handle($file, $dest, [
                'maxSize' => 5 * 1024 * 1024,
                'allowedTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                'prefix' => 'gallery_',
            ]);
            if ($rel === false) {
                \flash('error', 'Image upload failed.');
                $this->response->redirect(\base_url('admin/gallery/edit/' . $id));
            }
            \GalleryModel::deleteStoredImage((string) ($existing['image_path'] ?? ''));
            $update['image_path'] = $rel;
        }

        $model->update((int) $id, $update);
        \flash('success', 'Gallery item updated.');
        $this->response->redirect(\base_url('admin/gallery'));
    }

    public function delete(string $id): void
    {
        $model = new \GalleryModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $model->delete((int) $id);
        \flash('success', 'Gallery item deleted.');
        $this->response->redirect(\base_url('admin/gallery'));
    }

    public function reorder(): void
    {
        $raw = $this->request->post('order', '');
        if (!\is_string($raw)) {
            $this->response->json(['success' => false, 'message' => 'Invalid payload'], 400);
        }
        $decoded = \json_decode($raw, true);
        if (!\is_array($decoded)) {
            $this->response->json(['success' => false, 'message' => 'Invalid JSON'], 400);
        }
        $model = new \GalleryModel();
        $model->updateSortOrder($decoded);
        $this->response->json(['success' => true]);
    }

    public function toggleFeatured(string $id): void
    {
        $model = new \GalleryModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $next = ((int) ($item['is_featured'] ?? 0)) === 1 ? 0 : 1;
        $model->update((int) $id, ['is_featured' => $next]);
        $this->redirectBack(\base_url('admin/gallery'));
    }

    public function toggleActive(string $id): void
    {
        $model = new \GalleryModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $next = ((int) ($item['is_active'] ?? 0)) === 1 ? 0 : 1;
        $model->update((int) $id, ['is_active' => $next]);
        $this->redirectBack(\base_url('admin/gallery'));
    }
}
