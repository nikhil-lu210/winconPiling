<?php

declare(strict_types=1);

/**
 * Route rows: [HTTP_METHOD, path pattern, controller class name, action method].
 * Admin controllers use PHP namespace Admin\ (see app/Controllers/Admin/).
 */
return [
    ['GET', '/', 'HomeController', 'index'],
    ['GET', '/about', 'AboutController', 'index'],
    ['GET', '/services', 'ServicesController', 'index'],
    ['GET', '/services/piling', 'ServicesController', 'piling'],
    ['GET', '/portfolio', 'PortfolioController', 'index'],
    ['GET', '/videos', 'VideosController', 'index'],
    ['GET', '/contact', 'ContactController', 'index'],
    ['POST', '/contact/send', 'ContactController', 'send'],
    ['GET', '/land-investment', 'LandController', 'index'],

    ['GET', '/admin', 'Admin\\AuthController', 'loginPage'],
    ['POST', '/admin/login', 'Admin\\AuthController', 'login'],
    ['POST', '/admin/logout', 'Admin\\AuthController', 'logout'],

    ['GET', '/admin/dashboard', 'Admin\\DashboardController', 'index'],

    ['GET', '/admin/content', 'Admin\\ContentController', 'index'],
    ['GET', '/admin/content/edit/{id}', 'Admin\\ContentController', 'edit'],
    ['POST', '/admin/content/update/{id}', 'Admin\\ContentController', 'update'],

    ['GET', '/admin/gallery', 'Admin\\GalleryController', 'index'],
    ['GET', '/admin/gallery/create', 'Admin\\GalleryController', 'create'],
    ['POST', '/admin/gallery/store', 'Admin\\GalleryController', 'store'],
    ['GET', '/admin/gallery/edit/{id}', 'Admin\\GalleryController', 'edit'],
    ['POST', '/admin/gallery/update/{id}', 'Admin\\GalleryController', 'update'],
    ['POST', '/admin/gallery/delete/{id}', 'Admin\\GalleryController', 'delete'],
    ['POST', '/admin/gallery/reorder', 'Admin\\GalleryController', 'reorder'],

    ['GET', '/admin/videos', 'Admin\\VideoController', 'index'],
    ['GET', '/admin/videos/create', 'Admin\\VideoController', 'create'],
    ['POST', '/admin/videos/store', 'Admin\\VideoController', 'store'],
    ['GET', '/admin/videos/edit/{id}', 'Admin\\VideoController', 'edit'],
    ['POST', '/admin/videos/update/{id}', 'Admin\\VideoController', 'update'],
    ['POST', '/admin/videos/delete/{id}', 'Admin\\VideoController', 'delete'],

    ['GET', '/admin/messages', 'Admin\\MessageController', 'index'],
    ['GET', '/admin/messages/view/{id}', 'Admin\\MessageController', 'view'],
    ['POST', '/admin/messages/star/{id}', 'Admin\\MessageController', 'star'],
    ['POST', '/admin/messages/delete/{id}', 'Admin\\MessageController', 'delete'],
    ['POST', '/admin/messages/mark-read', 'Admin\\MessageController', 'markRead'],

    ['GET', '/admin/services', 'Admin\\ServiceController', 'index'],
    ['GET', '/admin/services/create', 'Admin\\ServiceController', 'create'],
    ['POST', '/admin/services/store', 'Admin\\ServiceController', 'store'],
    ['GET', '/admin/services/edit/{id}', 'Admin\\ServiceController', 'edit'],
    ['POST', '/admin/services/update/{id}', 'Admin\\ServiceController', 'update'],
    ['POST', '/admin/services/delete/{id}', 'Admin\\ServiceController', 'delete'],

    ['GET', '/admin/land', 'Admin\\LandController', 'index'],
    ['GET', '/admin/land/create', 'Admin\\LandController', 'create'],
    ['POST', '/admin/land/store', 'Admin\\LandController', 'store'],
    ['GET', '/admin/land/edit/{id}', 'Admin\\LandController', 'edit'],
    ['POST', '/admin/land/update/{id}', 'Admin\\LandController', 'update'],
    ['POST', '/admin/land/delete/{id}', 'Admin\\LandController', 'delete'],
];
