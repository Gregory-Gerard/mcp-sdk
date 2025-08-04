<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}

$fileHeaderParts = [
    <<<'EOF'
        This file is part of the Symfony package.

        (c) Fabien Potencier <fabien@symfony.com>

        EOF,
    <<<'EOF'

        For the full copyright and license information, please view the LICENSE
        file that was distributed with this source code.
        EOF,
];

return (new PhpCsFixer\Config())
    // @see https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/pull/7777
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'protected_to_private' => false,
        'declare_strict_types' => false,
        'header_comment' => [
            'header' => implode('', $fileHeaderParts),
        ],
        'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
        'trailing_comma_in_multiline' => [
            'elements' => [
                'array_destructuring',
                'arrays',
                'match',
                // Removed 'parameters' because it's not supported by PHP 7.4
            ],
        ],
        'modernize_strpos' => false, // Also not supported by PHP 7.4
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->in(__DIR__.'/{.phpstan,demo,examples,fixtures,src}')
            ->append([__FILE__])
            ->exclude('var')
    )
;
