<?php

$finder = (new PhpCsFixer\Finder())
    ->in(['src', 'tests'])
    ->exclude(['var', __DIR__.'/src/Kernel.php'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => [
            'sort_algorithm' => 'length',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
;
