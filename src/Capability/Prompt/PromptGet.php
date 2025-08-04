<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Capability\Prompt;

/**
 * @readonly
 */
final class PromptGet
{
    public string $id;
    public string $name;

    /**
     * @var array<string, mixed>
     */
    public array $arguments;

    /**
     * @param array<string, mixed> $arguments
     */
    public function __construct(string $id, string $name, array $arguments = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->arguments = $arguments;
    }
}
