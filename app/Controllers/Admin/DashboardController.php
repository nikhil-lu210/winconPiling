<?php

declare(strict_types=1);

namespace Admin;

final class DashboardController extends AdminBaseController
{
    public function index(): void
    {
        $galleryModel = new \GalleryModel();
        $videoModel = new \VideoModel();
        $messageModel = new \MessageModel();
        $landModel = new \LandListingModel();

        $galleryCount = $galleryModel->countAll();
        $videoCount = $videoModel->countAll();
        $messageCount = $messageModel->countAll();
        $unreadMessages = $messageModel->countUnread();
        $landCount = $landModel->countAll();
        $recentMessages = $messageModel->getRecent(5);

        $this->render('admin/dashboard/index', [
            'pageTitle' => 'Dashboard',
            'galleryCount' => $galleryCount,
            'videoCount' => $videoCount,
            'messageCount' => $messageCount,
            'unreadMessages' => $unreadMessages,
            'landCount' => $landCount,
            'recentMessages' => $recentMessages,
        ]);
    }
}
