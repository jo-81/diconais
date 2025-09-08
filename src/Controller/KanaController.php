<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class KanaController extends AbstractController
{
    #[Route('/kana', name: 'kana.list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('kana/index.html.twig');
    }
}
