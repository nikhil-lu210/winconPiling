<?php

declare(strict_types=1);

final class VideosController extends BaseController
{
    public function index(): void
    {
        $videoModel = new VideoModel();
        $all = $videoModel->getAll();
        /** @var array<string, array<int, array<string, mixed>>> $grouped */
        $grouped = [];
        foreach ($all as $row) {
            $c = (string) $row['category'];
            $grouped[$c][] = $row;
        }
        $settings = $this->siteSettings();

        $this->render('videos/index', [
            'pageTitle' => 'Project Videos | Wincon Pilling Construction Limited',
            'metaDescription' => 'Construction and engineering project videos from Wincon Pilling Construction Nigeria.',
            'videosByCategory' => $grouped,
            'settings' => $settings,
        ]);
    }
}
