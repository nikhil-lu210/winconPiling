<?php

declare(strict_types=1);

final class LandController extends BaseController
{
    public function index(): void
    {
        $landModel = new LandListingModel();
        $landListings = $landModel->getAll();
        $pageModel = new PageContentModel();
        $content = $pageModel->getByPage('land');
        $settings = $this->siteSettings();

        $this->render('land/index', [
            'pageTitle' => 'Land Investment & Real Estate - Wincon Pilling Construction Limited',
            'metaDescription' => 'Verified land opportunities and real estate with Wincon Pilling Construction Limited.',
            'landListings' => $landListings,
            'content' => $content,
            'settings' => $settings,
        ]);
    }
}
