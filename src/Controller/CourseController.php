<?php

namespace App\Controller;

use App\Entity\Course;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CourseController extends AbstractController
{
    #[Route('/cours', name: 'course.list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('course/index.html.twig');
    }

    #[Route('/cours/{slug}', name: 'course.show', methods: ['GET'])]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }
}
