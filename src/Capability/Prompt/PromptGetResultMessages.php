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
final class PromptGetResultMessages
{
    public string $role;
    public string $result;

    /**
     * @var "text"|"image"|"audio"|"resource"|non-empty-string
     */
    public string $type;
    public string $mimeType;
    public ?string $uri;

    public function __construct(string $role, string $result, string $type = 'text', string $mimeType = 'text/plan', ?string $uri = null)
    {
        $this->role = $role;
        $this->result = $result;
        $this->type = $type;
        $this->mimeType = $mimeType;
        $this->uri = $uri;
    }
}
