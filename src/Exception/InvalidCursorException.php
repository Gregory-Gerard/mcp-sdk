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

final class InvalidCursorException extends \InvalidArgumentException implements ExceptionInterface
{
    /**
     * @readonly
     */
    public string $cursor;

    public function __construct(
        string $cursor
    ) {
        $this->cursor = $cursor;
        parent::__construct(\sprintf('Invalid value for pagination parameter "cursor": "%s"', $cursor));
    }
}
