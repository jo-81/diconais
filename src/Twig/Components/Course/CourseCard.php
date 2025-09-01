<?php

namespace App\Twig\Components\Course;

use App\Entity\Course;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CourseCard
{
    public Course $course;
}
