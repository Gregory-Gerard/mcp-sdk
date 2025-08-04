<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Capability\Tool;

/**
 * @readonly
 */
final class ToolCallResult
{
    public string $result;

    /**
     * @var "text"|"image"|"audio"|"resource"|non-empty-string
     */
    public string $type;
    public string $mimeType;
    public bool $isError;
    public ?string $uri;

    public function __construct(string $result, string $type = 'text', string $mimeType = 'text/plan', bool $isError = false, ?string $uri = null)
    {
        $this->result = $result;
        $this->type = $type;
        $this->mimeType = $mimeType;
        $this->isError = $isError;
        $this->uri = $uri;
    }
}
