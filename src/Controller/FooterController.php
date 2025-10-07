<?php

namespace App\Controller;

use App\Repository\KanjiRepository;
use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FooterController extends AbstractController
{
    public function __construct(private CourseRepository $courseRepository, private KanjiRepository $kanjiRepository)
    {
    }

    public function index(): Response
    {
        return $this->render('footer/index.html.twig', [
            'courses' => $this->courseRepository->findPublishedWithCategory(4),
            'kanji' => $this->kanjiRepository->findOneBy([], ['id' => 'DESC']),
        ]);
    }
}
