<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
use App\Form\LinkType;

class ShortController extends AbstractController
{
    #[Route('/short', name: 'app_short', methods: ['GET', 'POST'])]
    public function index(Request $request)
    {
        $link = new Link();
        $link->setCreatedAt(new \DateTime());
        $link->setModifiedAt(new \DateTime());
        $link->setLastUsedAt(new \DateTime());
        $link->setUsedTimesCount(0);

        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($link);
            $em->flush();
        }

        return $this->render('short/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
