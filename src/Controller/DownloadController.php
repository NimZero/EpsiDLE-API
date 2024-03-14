<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/download')]
class DownloadController extends AbstractController
{
    #[Route('', name: 'app_download')]
    public function appDownload(): Response
    {
        return $this->render('download/index.html.twig');
    }
}
