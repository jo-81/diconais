<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('config')
    ->exclude('bin')
    ->exclude('migrations')
    ->exclude('public')
    ->exclude('templates')
    ->exclude('translations')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder($finder)
;
