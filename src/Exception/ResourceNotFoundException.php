<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Exception;

use Symfony\AI\McpSdk\Capability\Resource\ResourceRead;

final class ResourceNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    /**
     * @readonly
     */
    public ResourceRead $readRequest;

    public function __construct(
        ResourceRead $readRequest
    ) {
        $this->readRequest = $readRequest;
        parent::__construct(\sprintf('Resource not found for uri: "%s"', $readRequest->uri));
    }
}
