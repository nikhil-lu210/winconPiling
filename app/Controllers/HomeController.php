<?php

declare(strict_types=1);

final class HomeController extends BaseController
{
    public function index(): void
    {
        $pageModel = new PageContentModel();
        $content = $pageModel->getByPage('home');

        $galleryModel = new GalleryModel();
        $featuredGallery = $galleryModel->getFeatured(3);

        $videoModel = new VideoModel();
        $featuredVideos = $videoModel->getFeatured(2);

        $serviceModel = new ServiceModel();
        $services = $serviceModel->getAll();

        $landModel = new LandListingModel();
        $landListings = array_slice($landModel->getAll(), 0, 2);

        $settings = $this->siteSettings();

        $this->render('home/index', [
            'pageTitle' => 'Wincon Pilling Construction Limited',
            'metaDescription' => 'Wincon Pilling Construction Limited — engineering, deep foundations, and civil construction across Nigeria.',
            'content' => $content,
            'featuredGallery' => $featuredGallery,
            'featuredVideos' => $featuredVideos,
            'services' => $services,
            'landListings' => $landListings,
            'settings' => $settings,
        ]);
    }
}
