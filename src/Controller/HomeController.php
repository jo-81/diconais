<?php

namespace App\Controller;

use App\Repository\KanjiRepository;
use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    public function __construct(private CourseRepository $courseRepository, private KanjiRepository $kanjiRepository)
    {
    }

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'courses' => $this->courseRepository->findBy(['published' => true], ['createdAt' => 'DESC'], 3),
            'kanjis' => $this->kanjiRepository->findBy([], ['id' => 'DESC'], 6),
        ]);
    }
}
