<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Tests\Server\RequestHandler;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\AI\McpSdk\Capability\Prompt\MetadataInterface;
use Symfony\AI\McpSdk\Capability\PromptChain;
use Symfony\AI\McpSdk\Message\Request;
use Symfony\AI\McpSdk\Server\RequestHandler\PromptListHandler;

#[Small]
#[CoversClass(PromptListHandler::class)]
class PromptListHandlerTest extends TestCase
{
    public function testHandleEmpty(): void
    {
        $handler = new PromptListHandler(new PromptChain([]));
        $message = new Request(1, 'prompts/list', []);
        $response = $handler->createResponse($message);
        $this->assertEquals(1, $response->id);
        $this->assertEquals(['prompts' => []], $response->result);
    }

    public function testHandleReturnAll(): void
    {
        $item = self::createMetadataItem();
        $handler = new PromptListHandler(new PromptChain([$item]));
        $message = new Request(1, 'prompts/list', []);
        $response = $handler->createResponse($message);
        $this->assertCount(1, $response->result['prompts']);
        $this->assertArrayNotHasKey('nextCursor', $response->result);
    }

    public function testHandlePagination(): void
    {
        $item = self::createMetadataItem();
        $handler = new PromptListHandler(new PromptChain([$item, $item]), 2);
        $message = new Request(1, 'prompts/list', []);
        $response = $handler->createResponse($message);
        $this->assertCount(2, $response->result['prompts']);
        $this->assertArrayHasKey('nextCursor', $response->result);
    }

    private static function createMetadataItem(): MetadataInterface
    {
        return new class implements MetadataInterface {
            public function getName(): string
            {
                return 'greet';
            }

            public function getDescription(): string
            {
                return 'Greet a person with a nice message';
            }

            public function getArguments(): array
            {
                return [
                    [
                        'name' => 'first name',
                        'description' => 'The name of the person to greet',
                        'required' => false,
                    ],
                ];
            }
        };
    }
}
