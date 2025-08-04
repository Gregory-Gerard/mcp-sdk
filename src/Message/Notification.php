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

/**
 * @readonly
 */
final class Notification implements \JsonSerializable
{
    public string $method;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $params;

    /**
     * @param array<string, mixed>|null $params
     */
    public function __construct(string $method, ?array $params = null)
    {
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * @param array{method: string, params?: array<string, mixed>} $data
     */
    public static function from(array $data): self
    {
        return new self(
            $data['method'],
            $data['params'] ?? null,
        );
    }

    /**
     * @return array{jsonrpc: string, method: string, params: array<string, mixed>|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'jsonrpc' => '2.0',
            'method' => $this->method,
            'params' => $this->params,
        ];
    }

    public function __toString(): string
    {
        return \sprintf('%s', $this->method);
    }
}
