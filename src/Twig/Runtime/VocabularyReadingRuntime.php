<?php

namespace App\Twig\Runtime;

use App\Entity\Kanji;
use App\Entity\Vocabulary;
use App\Repository\KanjiRepository;
use Twig\Extension\RuntimeExtensionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class VocabularyReadingRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private KanjiRepository $kanjiRepository,
    ) {
    }

    public function doReading(Vocabulary $vocabulary): string
    {
        if (is_null($vocabulary->getReading())) {
            return $this->getReadingWithOnlyKanjis($vocabulary->getKanjis()->toArray());
        }

        return $this->generateReading($vocabulary);
    }

    private function getReadingWithOnlyKanjis(array $kanjis): string
    {
        $reading = '';
        foreach ($kanjis as $kanji) {
            $reading .= $this->generateLink($kanji);
        }

        return $reading;
    }

    private function generateReading(Vocabulary $vocabulary): string
    {
        $reading = '';
        foreach (grapheme_str_split($vocabulary->getReading()) as $kanji) {
            $reading .= $this->generateLinkByIdeogramme($kanji);
        }

        return $reading;
    }

    private function generateLink(Kanji $kanji): string
    {
        $url = $this->urlGenerator->generate('ideogramme.show', ['id' => $kanji->getId()]);

        return '<a class="text-decoration-none" href="'.$url.'">'.$kanji->getIdeogramme().'</a>';
    }

    private function generateLinkByIdeogramme(string $ideogramme): string
    {
        $kanji = $this->kanjiRepository->findOneBy(['ideogramme' => $ideogramme]);
        if ($kanji instanceof Kanji) {
            return $this->generateLink($kanji);
        }

        return $ideogramme;
    }
}
