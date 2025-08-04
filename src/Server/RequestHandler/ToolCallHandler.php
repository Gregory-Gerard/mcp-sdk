<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Server\RequestHandler;

use Symfony\AI\McpSdk\Capability\Tool\ToolCall;
use Symfony\AI\McpSdk\Capability\Tool\ToolExecutorInterface;
use Symfony\AI\McpSdk\Exception\ExceptionInterface;
use Symfony\AI\McpSdk\Exception\InvalidArgumentException;
use Symfony\AI\McpSdk\Message\Error;
use Symfony\AI\McpSdk\Message\Request;
use Symfony\AI\McpSdk\Message\Response;

final class ToolCallHandler extends BaseRequestHandler
{
    /**
     * @readonly
     */
    private ToolExecutorInterface $toolExecutor;

    public function __construct(ToolExecutorInterface $toolExecutor)
    {
        $this->toolExecutor = $toolExecutor;
    }

    /**
     * @return Response|Error
     */
    public function createResponse(Request $message)
    {
        $name = $message->params['name'];
        $arguments = $message->params['arguments'] ?? [];

        try {
            $result = $this->toolExecutor->call(new ToolCall(uniqid('', true), $name, $arguments));
        } catch (ExceptionInterface $exception) {
            return Error::internalError($message->id, 'Error while executing tool');
        }

        switch ($result->type) {
            case 'text':
                $content = [
                    'type' => 'text',
                    'text' => $result->result,
                ];
                break;
            case 'image':
            case 'audio':
                $content = [
                    'type' => $result->type,
                    'data' => $result->result,
                    'mimeType' => $result->mimeType,
                ];
                break;
            case 'resource':
                $content = [
                    'type' => 'resource',
                    'resource' => [
                        'uri' => $result->uri,
                        'mimeType' => $result->mimeType,
                        'text' => $result->result,
                    ],
                ];
                break;
            default:
                throw new InvalidArgumentException('Unsupported tool result type: '.$result->type);
        }

        return new Response($message->id, [
            'content' => [$content], // TODO: allow multiple `ToolCallResult`s in the future
            'isError' => $result->isError,
        ]);
    }

    protected function supportedMethod(): string
    {
        return 'tools/call';
    }
}
