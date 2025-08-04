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
final class Response implements \JsonSerializable
{
    /**
     * @var int|string
     */
    public $id;

    /**
     * @var array<string, mixed>
     */
    public array $result;

    /**
     * @param array<string, mixed> $result
     * @param string|int           $id
     */
    public function __construct($id, array $result = [])
    {
        $this->id = $id;
        $this->result = $result;
    }

    /**
     * @return array{jsonrpc: string, id: string|int, result: array<string, mixed>}
     */
    public function jsonSerialize(): array
    {
        return [
            'jsonrpc' => '2.0',
            'id' => $this->id,
            'result' => $this->result,
        ];
    }
}
