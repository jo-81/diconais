<?php

namespace App\Tests\Integration\Twig\Components;

use App\Twig\Components\Course\CourseList;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

class CourseListTest extends KernelTestCase
{
    use InteractsWithLiveComponents;

    public function testCanRenderAndReload(): void
    {
        $testComponent = $this->createLiveComponent(CourseList::class, ['query' => 'The course one']);
        $this->assertInstanceOf(CourseList::class, $testComponent->component());
        $this->assertEquals('The course one', $testComponent->component()->query);
        $renderedOutput = $testComponent->render();
        $this->assertStringContainsString('The course one', (string) $renderedOutput); 
    }
}