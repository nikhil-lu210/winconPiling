<?php

declare(strict_types=1);

final class PortfolioController extends BaseController
{
    public function index(): void
    {
        $raw = (string) $this->request->get('category', '');
        if ($raw === '') {
            $raw = 'all';
        }
        $map = [
            'real-estate' => 'real_estate',
        ];
        $cat = $map[$raw] ?? $raw;

        $galleryModel = new GalleryModel();
        if ($cat === 'all' || $cat === '') {
            $galleryItems = $galleryModel->getAll();
        } else {
            $galleryItems = $galleryModel->getByCategory($cat);
        }

        $settings = $this->siteSettings();

        $this->render('portfolio/index', [
            'pageTitle' => 'Our Portfolio - Wincon Pilling Construction Limited',
            'metaDescription' => 'Portfolio of piling, civil, real estate, and infrastructure projects across Nigeria.',
            'galleryItems' => $galleryItems,
            'activeCategory' => ($raw === '' || $raw === 'all') ? 'all' : $raw,
            'settings' => $settings,
        ]);
    }
}
