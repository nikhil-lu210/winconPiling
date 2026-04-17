<?php

declare(strict_types=1);

namespace Admin;

final class SiteSettingController extends AdminBaseController
{
    public function index(): void
    {
        $rows = $this->settings->getAllRows();
        $this->render('admin/settings/index', [
            'pageTitle' => 'Site settings',
            'settingRows' => $rows,
        ]);
    }

    public function updateAll(): void
    {
        $posted = $_POST['settings'] ?? null;
        if (!\is_array($posted)) {
            \flash('error', 'Invalid form submission.');
            $this->response->redirect(\base_url('admin/settings'));
        }

        $allowedKeys = [];
        foreach ($this->settings->getAllRows() as $row) {
            $k = (string) ($row['setting_key'] ?? '');
            if ($k !== '') {
                $allowedKeys[$k] = true;
            }
        }

        foreach ($allowedKeys as $key => $_) {
            if (!\array_key_exists($key, $posted)) {
                continue;
            }
            $raw = $posted[$key];
            $val = \is_string($raw) ? $raw : '';
            $this->settings->set($key, $val);
        }

        \flash('success', 'Settings saved.');
        $this->response->redirect(\base_url('admin/settings'));
    }
}
