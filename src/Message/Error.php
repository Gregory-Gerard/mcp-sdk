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
final class Error implements \JsonSerializable
{
    /**
     * @var int|string
     */
    public $id;
    public int $code;
    public string $message;
    public const INVALID_REQUEST = -32600;
    public const METHOD_NOT_FOUND = -32601;
    public const INVALID_PARAMS = -32602;
    public const INTERNAL_ERROR = -32603;
    public const PARSE_ERROR = -32700;
    public const RESOURCE_NOT_FOUND = -32002;

    /**
     * @param string|int $id
     */
    public function __construct($id, int $code, string $message)
    {
        $this->id = $id;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @param string|int $id
     */
    public static function invalidRequest($id, string $message = 'Invalid Request'): self
    {
        return new self($id, self::INVALID_REQUEST, $message);
    }

    /**
     * @param string|int $id
     */
    public static function methodNotFound($id, string $message = 'Method not found'): self
    {
        return new self($id, self::METHOD_NOT_FOUND, $message);
    }

    /**
     * @param string|int $id
     */
    public static function invalidParams($id, string $message = 'Invalid params'): self
    {
        return new self($id, self::INVALID_PARAMS, $message);
    }

    /**
     * @param string|int $id
     */
    public static function internalError($id, string $message = 'Internal error'): self
    {
        return new self($id, self::INTERNAL_ERROR, $message);
    }

    /**
     * @param string|int $id
     */
    public static function parseError($id, string $message = 'Parse error'): self
    {
        return new self($id, self::PARSE_ERROR, $message);
    }

    /**
     * @return array{
     *     jsonrpc: string,
     *     id: string|int,
     *     error: array{code: int, message: string}
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'jsonrpc' => '2.0',
            'id' => $this->id,
            'error' => [
                'code' => $this->code,
                'message' => $this->message,
            ],
        ];
    }
}
