<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Server\Transport\Sse;

use Symfony\AI\McpSdk\Server\TransportInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @readonly
 */
final class StreamTransport implements TransportInterface
{
    private string $messageEndpoint;
    private StoreInterface $store;
    private Uuid $id;

    public function __construct(string $messageEndpoint, StoreInterface $store, Uuid $id)
    {
        $this->messageEndpoint = $messageEndpoint;
        $this->store = $store;
        $this->id = $id;
    }

    public function initialize(): void
    {
        ignore_user_abort(true);
        $this->flushEvent('endpoint', $this->messageEndpoint);
    }

    public function isConnected(): bool
    {
        return 0 === connection_aborted();
    }

    public function receive(): \Generator
    {
        yield $this->store->pop($this->id);
    }

    public function send(string $data): void
    {
        $this->flushEvent('message', $data);
    }

    public function close(): void
    {
        $this->store->remove($this->id);
    }

    private function flushEvent(string $event, string $data): void
    {
        echo \sprintf('event: %s', $event).\PHP_EOL;
        echo \sprintf('data: %s', $data).\PHP_EOL;
        echo \PHP_EOL;
        if (false !== ob_get_length()) {
            ob_flush();
        }
        flush();
    }
}
