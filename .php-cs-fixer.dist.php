<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'array_syntax' => ['syntax' => 'short'],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_functions' => false,
            'import_constants' => false,
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'concat_space' => ['spacing' => 'one']
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
