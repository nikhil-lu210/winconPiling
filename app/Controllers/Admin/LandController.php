<?php

declare(strict_types=1);

namespace Admin;

final class LandController extends AdminBaseController
{
    public function index(): void
    {
        $model = new \LandListingModel();
        $items = $model->getAll(false);
        $this->render('admin/land/index', [
            'pageTitle' => 'Land listings',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        $this->render('admin/land/form', [
            'pageTitle' => 'Add land listing',
            'item' => null,
            'isEdit' => false,
            'features' => [],
        ]);
    }

    public function store(): void
    {
        $validator = new \Validator();
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'category' => (string) $this->request->post('category', ''),
            'location' => (string) $this->request->post('location', ''),
            'size_sqm' => $this->request->post('size_sqm', ''),
            'price' => (string) $this->request->post('price', ''),
            'description' => (string) $this->request->postRaw('description', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'category' => 'required|in:commercial,residential',
            'size_sqm' => 'numeric',
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
            $this->response->redirect(\base_url('admin/land/create'));
        }

        $upload = new \FileUpload();
        $dest = \ROOT_PATH . '/public/assets/uploads/land/';
        $rel = $upload->handle($file, $dest, [
            'maxSize' => 5 * 1024 * 1024,
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/webp'],
            'prefix' => 'land_',
        ]);
        if ($rel === false) {
            \flash('error', 'Image upload failed.');
            $this->response->redirect(\base_url('admin/land/create'));
        }

        $featuresJson = $this->collectFeaturesJson();
        $model = new \LandListingModel();
        $model->create([
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'location' => $data['location'],
            'size_sqm' => $data['size_sqm'] !== '' ? (int) $data['size_sqm'] : null,
            'price' => $data['price'],
            'features' => $featuresJson,
            'image_path' => $rel,
            'is_active' => $this->request->post('is_active') ? 1 : 0,
            'sort_order' => (int) $data['sort_order'],
        ]);

        \flash('success', 'Land listing added.');
        $this->response->redirect(\base_url('admin/land'));
    }

    public function edit(string $id): void
    {
        $model = new \LandListingModel();
        $item = $model->getById((int) $id);
        if ($item === null) {
            $this->abort(404);
        }
        $this->render('admin/land/form', [
            'pageTitle' => 'Edit land listing',
            'item' => $item,
            'isEdit' => true,
            'features' => $model->decodeFeatures($item),
        ]);
    }

    public function update(string $id): void
    {
        $model = new \LandListingModel();
        $existing = $model->getById((int) $id);
        if ($existing === null) {
            $this->abort(404);
        }

        $validator = new \Validator();
        $data = [
            'title' => (string) $this->request->post('title', ''),
            'category' => (string) $this->request->post('category', ''),
            'location' => (string) $this->request->post('location', ''),
            'size_sqm' => $this->request->post('size_sqm', ''),
            'price' => (string) $this->request->post('price', ''),
            'description' => (string) $this->request->postRaw('description', ''),
            'sort_order' => $this->request->post('sort_order', '0'),
        ];
        $ok = $validator->validate($data, [
            'title' => 'required|max:255',
            'category' => 'required|in:commercial,residential',
            'size_sqm' => 'numeric',
            'sort_order' => 'numeric',
        ]);

        if (!$ok) {
            \Session::flash('errors', $validator->errors);
            \flash('error', 'Please fix the errors below.');
            $this->response->redirect(\base_url('admin/land/edit/' . $id));
        }

        $update = [
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'location' => $data['location'],
            'size_sqm' => $data['size_sqm'] !== '' ? (int) $data['size_sqm'] : null,
            'price' => $data['price'],
            'features' => $this->collectFeaturesJson(),
            'is_active' => $this->request->post('is_active') ? 1 : 0,
            'sort_order' => (int) $data['sort_order'],
        ];

        $file = $this->request->files('image');
        if (\is_array($file) && (int) ($file['error'] ?? \UPLOAD_ERR_NO_FILE) === \UPLOAD_ERR_OK) {
            $upload = new \FileUpload();
            $dest = \ROOT_PATH . '/public/assets/uploads/land/';
            $rel = $upload->handle($file, $dest, [
                'maxSize' => 5 * 1024 * 1024,
                'allowedTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                'prefix' => 'land_',
            ]);
            if ($rel === false) {
                \flash('error', 'Image upload failed.');
                $this->response->redirect(\base_url('admin/land/edit/' . $id));
            }
            \GalleryModel::deleteStoredImage((string) ($existing['image_path'] ?? ''));
            $update['image_path'] = $rel;
        }

        $model->update((int) $id, $update);
        \flash('success', 'Land listing updated.');
        $this->response->redirect(\base_url('admin/land'));
    }

    public function delete(string $id): void
    {
        $model = new \LandListingModel();
        if ($model->getById((int) $id) === null) {
            $this->abort(404);
        }
        $model->delete((int) $id);
        \flash('success', 'Land listing deleted.');
        $this->response->redirect(\base_url('admin/land'));
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
        $model = new \LandListingModel();
        $model->updateSortOrder($decoded);
        $this->response->json(['success' => true]);
    }

    private function collectFeaturesJson(): string
    {
        $raw = $this->request->post('features');
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
