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
final class PromptGetResult
{
    public string $description;
    /**
     * @var list<PromptGetResultMessages>
     */
    public array $messages;

    /**
     * @param list<PromptGetResultMessages> $messages
     */
    public function __construct(string $description, array $messages = [])
    {
        $this->description = $description;
        $this->messages = $messages;
    }
}
