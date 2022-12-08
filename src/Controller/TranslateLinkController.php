<?php

namespace App\Controller;

use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslateLinkController extends AbstractController
{
    #[Route('{shortLink}', name: 'app_translate_link')]
    public function index($shortLink, LinkRepository $linkRepository): Response
    {
        $link = $linkRepository->findOneBy(['shortLink' => $shortLink]);

        $link->setUsedTimesCount($link->getUsedTimesCount() + 1);

        $link->setLastUsedAt(new \DateTime());

        $linkRepository->save($link, true);

        // return $this->render('translate_link/index.html.twig', [
        //     'controller_name' => $link->getLongLink(),
        // ]);

        return $this->redirect($link->getLongLink());
    }
}
