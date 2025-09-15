<?php

namespace App\Controller;

use App\Entity\Ideogramme;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class IdeogrammeController extends AbstractController
{
    #[Route('/ideogrammes', name: 'ideogramme.list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('ideogramme/index.html.twig');
    }

    #[Route('/ideogrammes/{id}', name: 'ideogramme.show', methods: ['GET'])]
    public function show(Ideogramme $ideogramme): Response
    {
        return $this->render('ideogramme/show.html.twig', [
            'ideogramme' => $ideogramme,
            'class_name' => get_class($ideogramme),
        ]);
    }
}
