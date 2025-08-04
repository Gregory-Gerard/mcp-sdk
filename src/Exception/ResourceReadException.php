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

final class ResourceReadException extends \RuntimeException implements ExceptionInterface
{
    /**
     * @readonly
     */
    public ResourceRead $readRequest;

    public function __construct(
        ResourceRead $readRequest,
        ?\Throwable $previous = null
    ) {
        $this->readRequest = $readRequest;
        parent::__construct(\sprintf('Reading resource "%s" failed with error: %s', $readRequest->uri, (($nullsafeVariable1 = $previous) ? $nullsafeVariable1->getMessage() : null) ?? ''), 0, $previous);
    }
}
