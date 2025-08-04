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
final class Request implements \JsonSerializable
{
    /**
     * @var int|string
     */
    public $id;
    public string $method;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $params;

    /**
     * @param array<string, mixed>|null $params
     * @param int|string                $id
     */
    public function __construct($id, string $method, ?array $params = null)
    {
        $this->id = $id;
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * @param array{id: string|int, method: string, params?: array<string, mixed>} $data
     */
    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['method'],
            $data['params'] ?? null,
        );
    }

    /**
     * @return array{jsonrpc: string, id: string|int, method: string, params: array<string, mixed>|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'jsonrpc' => '2.0',
            'id' => $this->id,
            'method' => $this->method,
            'params' => $this->params,
        ];
    }

    public function __toString(): string
    {
        return \sprintf('%s: %s', $this->id, $this->method);
    }
}
