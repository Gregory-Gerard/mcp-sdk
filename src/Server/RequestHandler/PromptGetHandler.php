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

use Symfony\AI\McpSdk\Capability\Prompt\PromptGet;
use Symfony\AI\McpSdk\Capability\Prompt\PromptGetterInterface;
use Symfony\AI\McpSdk\Exception\ExceptionInterface;
use Symfony\AI\McpSdk\Exception\InvalidArgumentException;
use Symfony\AI\McpSdk\Message\Error;
use Symfony\AI\McpSdk\Message\Request;
use Symfony\AI\McpSdk\Message\Response;

final class PromptGetHandler extends BaseRequestHandler
{
    /**
     * @readonly
     */
    private PromptGetterInterface $getter;

    public function __construct(PromptGetterInterface $getter)
    {
        $this->getter = $getter;
    }

    /**
     * @return Response|Error
     */
    public function createResponse(Request $message)
    {
        $name = $message->params['name'];
        $arguments = $message->params['arguments'] ?? [];

        try {
            $result = $this->getter->get(new PromptGet(uniqid('', true), $name, $arguments));
        } catch (ExceptionInterface $exception) {
            return Error::internalError($message->id, 'Error while handling prompt');
        }

        $messages = [];
        foreach ($result->messages as $resultMessage) {
            switch ($resultMessage->type) {
                case 'text':
                    $content = [
                        'type' => 'text',
                        'text' => $resultMessage->result,
                    ];
                    break;
                case 'image':
                case 'audio':
                    $content = [
                        'type' => $resultMessage->type,
                        'data' => $resultMessage->result,
                        'mimeType' => $resultMessage->mimeType,
                    ];
                    break;
                case 'resource':
                    $content = [
                        'type' => 'resource',
                        'resource' => [
                            'uri' => $resultMessage->uri,
                            'mimeType' => $resultMessage->mimeType,
                            'text' => $resultMessage->result,
                        ],
                    ];
                    break;
                default:
                    throw new InvalidArgumentException('Unsupported PromptGet result type: '.$resultMessage->type);
            }

            $messages[] = [
                'role' => $resultMessage->role,
                'content' => $content,
            ];
        }

        return new Response($message->id, [
            'description' => $result->description,
            'messages' => $messages,
        ]);
    }

    protected function supportedMethod(): string
    {
        return 'prompts/get';
    }
}
