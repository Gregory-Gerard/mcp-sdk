<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Message;

use Symfony\AI\McpSdk\Exception\InvalidInputMessageException;

final class Factory
{
    /**
     * @return iterable<Notification|Request|InvalidInputMessageException>
     *
     * @throws \JsonException When the input string is not valid JSON
     */
    public function create(string $input): iterable
    {
        $data = json_decode($input, true, 512, \JSON_THROW_ON_ERROR);

        if ('{' === $input[0]) {
            $data = [$data];
        }

        foreach ($data as $message) {
            if (!isset($message['method'])) {
                yield new InvalidInputMessageException('Invalid JSON-RPC request, missing "method".');
            } elseif (0 === strncmp((string) $message['method'], 'notifications/', \strlen('notifications/'))) {
                yield Notification::from($message);
            } else {
                yield Request::from($message);
            }
        }
    }
}
