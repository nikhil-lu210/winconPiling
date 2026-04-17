<?php

declare(strict_types=1);

final class AboutController extends BaseController
{
    public function index(): void
    {
        $pageModel = new PageContentModel();
        $content = $pageModel->getByPage('about');
        $settings = $this->siteSettings();

        $this->render('about/index', [
            'pageTitle' => 'About Us - Wincon Pilling Construction Limited',
            'metaDescription' => 'About Wincon Pilling Construction Limited — mission, vision, and values since 2008.',
            'content' => $content,
            'settings' => $settings,
        ]);
    }
}
