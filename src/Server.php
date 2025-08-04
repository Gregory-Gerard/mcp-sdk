<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\AI\McpSdk\Server\JsonRpcHandler;
use Symfony\AI\McpSdk\Server\TransportInterface;

/**
 * @readonly
 */
final class Server
{
    private JsonRpcHandler $jsonRpcHandler;
    private LoggerInterface $logger;

    public function __construct(JsonRpcHandler $jsonRpcHandler, ?LoggerInterface $logger = null)
    {
        $logger ??= new NullLogger();
        $this->jsonRpcHandler = $jsonRpcHandler;
        $this->logger = $logger;
    }

    public function connect(TransportInterface $transport): void
    {
        $transport->initialize();
        $this->logger->info('Transport initialized');

        while ($transport->isConnected()) {
            foreach ($transport->receive() as $message) {
                if (null === $message) {
                    continue;
                }

                try {
                    foreach ($this->jsonRpcHandler->process($message) as $response) {
                        if (null === $response) {
                            continue;
                        }

                        $transport->send($response);
                    }
                } catch (\JsonException $e) {
                    $this->logger->error('Failed to encode response to JSON', [
                        'message' => $message,
                        'exception' => $e,
                    ]);
                    continue;
                }
            }

            usleep(1000);
        }

        $transport->close();
        $this->logger->info('Transport closed');
    }
}
