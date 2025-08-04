<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Capability\Resource;

/**
 * @readonly
 */
final class ResourceReadResult
{
    public string $result;
    public string $uri;
    /**
     * @var "text"|"blob"
     */
    public string $type;
    public string $mimeType;

    public function __construct(string $result, string $uri, string $type = 'text', string $mimeType = 'text/plain')
    {
        $this->result = $result;
        $this->uri = $uri;
        $this->type = $type;
        $this->mimeType = $mimeType;
    }
}
