<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class KanjiController extends AbstractController
{
    #[Route('/kanji', name: 'kanji.list')]
    public function index(): Response
    {
        return $this->render('kanji/index.html.twig', [
            'controller_name' => 'KanjiController',
        ]);
    }
}
