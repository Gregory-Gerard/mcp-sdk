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
final class ResourceRead
{
    public string $id;
    public string $uri;

    public function __construct(string $id, string $uri)
    {
        $this->id = $id;
        $this->uri = $uri;
    }
}
