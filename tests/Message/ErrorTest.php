<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Tests\Message;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\AI\McpSdk\Message\Error;

#[Small]
#[CoversClass(Error::class)]
final class ErrorTest extends TestCase
{
    public function testWithIntegerId()
    {
        $error = new Error(1, -32602, 'Another error occurred');
        $expected = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'error' => [
                'code' => -32602,
                'message' => 'Another error occurred',
            ],
        ];

        $this->assertSame($expected, $error->jsonSerialize());
    }

    public function testWithStringId()
    {
        $error = new Error('abc', -32602, 'Another error occurred');
        $expected = [
            'jsonrpc' => '2.0',
            'id' => 'abc',
            'error' => [
                'code' => -32602,
                'message' => 'Another error occurred',
            ],
        ];

        $this->assertSame($expected, $error->jsonSerialize());
    }
}
