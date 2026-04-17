<?php

declare(strict_types=1);

final class ServicesController extends BaseController
{
    public function index(): void
    {
        $serviceModel = new ServiceModel();
        $services = $serviceModel->getAll();
        $pageModel = new PageContentModel();
        $content = $pageModel->getByPage('services');
        $settings = $this->siteSettings();

        $this->render('services/index', [
            'pageTitle' => 'Our Services - Wincon Pilling Construction Limited',
            'metaDescription' => 'Deep piling, geotechnical engineering, civil construction, land, and structural surveys — Wincon Pilling.',
            'services' => $services,
            'content' => $content,
            'settings' => $settings,
        ]);
    }

    public function piling(): void
    {
        $serviceModel = new ServiceModel();
        $service = $serviceModel->getBySlug('piling');
        if ($service === null) {
            $this->abort(404);
        }
        $service['sub_items_list'] = $serviceModel->decodeSubItems($service);

        $pageModel = new PageContentModel();
        $content = $pageModel->getByPage('services');
        $settings = $this->siteSettings();

        $this->render('services/piling', [
            'pageTitle' => 'Deep Piling Services - Wincon Pilling Construction Limited',
            'metaDescription' => 'Bored, driven, and micro piling — Wincon Pilling Construction Limited.',
            'service' => $service,
            'content' => $content,
            'settings' => $settings,
        ]);
    }
}
