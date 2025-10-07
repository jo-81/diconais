<?php

namespace App\Tests\Integration\Twig\Components;

use App\Twig\Components\Ideogramme\IdeogrammeList;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

class IdeogrammeListTest extends KernelTestCase
{
    use InteractsWithLiveComponents;

    /**
     * testFilteringByType.
     */
    public function testFilteringByType(): void
    {
        $component = $this->createLiveComponent(
            IdeogrammeList::class,
            ['ideogrammeType' => 'kanji']
        );

        $this->assertEquals('kanji', $component->component()->ideogrammeType);

        $component->set('ideogrammeType', 'key');
        $this->assertEquals('key', $component->component()->ideogrammeType);
    }

    /**
     * testResetAction.
     */
    public function testResetAction(): void
    {
        $component = $this->createLiveComponent(
            IdeogrammeList::class,
            [
                'query' => 'test',
                'ideogramme' => '日',
                'jlpt' => 'JLPT 1',
            ]
        );

        $component->call('reset');

        $this->assertEquals('', $component->component()->query);
        $this->assertEquals('', $component->component()->ideogramme);
        $this->assertEquals('', $component->component()->jlpt);
        $this->assertEquals('kanji', $component->component()->ideogrammeType);
    }

    /**
     * testPagination.
     */
    public function testPagination(): void
    {
        $component = $this->createLiveComponent(IdeogrammeList::class);

        $this->assertEquals(1, $component->component()->page);

        $component->call('nextPage');
        $this->assertEquals(2, $component->component()->page);

        $component->call('prevPage');
        $this->assertEquals(1, $component->component()->page);

        $component->call('selectedPage', ['page' => 5]);
        $this->assertEquals(5, $component->component()->page);
    }
}
