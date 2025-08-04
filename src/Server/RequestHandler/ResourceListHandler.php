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

use Symfony\AI\McpSdk\Capability\Resource\CollectionInterface;
use Symfony\AI\McpSdk\Message\Request;
use Symfony\AI\McpSdk\Message\Response;

final class ResourceListHandler extends BaseRequestHandler
{
    /**
     * @readonly
     */
    private CollectionInterface $collection;

    /**
     * @readonly
     */
    private int $pageSize;

    public function __construct(CollectionInterface $collection, int $pageSize = 20)
    {
        $this->collection = $collection;
        $this->pageSize = $pageSize;
    }

    public function createResponse(Request $message): Response
    {
        $nextCursor = null;
        $resources = [];

        $metadataList = $this->collection->getMetadata(
            $this->pageSize,
            $message->params['cursor'] ?? null
        );

        foreach ($metadataList as $metadata) {
            $nextCursor = $metadata->getUri();
            $result = [
                'uri' => $metadata->getUri(),
                'name' => $metadata->getName(),
            ];

            $description = $metadata->getDescription();
            if (null !== $description) {
                $result['description'] = $description;
            }

            $mimeType = $metadata->getMimeType();
            if (null !== $mimeType) {
                $result['mimeType'] = $mimeType;
            }

            $size = $metadata->getSize();
            if (null !== $size) {
                $result['size'] = $size;
            }

            $resources[] = $result;
        }

        $result = [
            'resources' => $resources,
        ];

        if (null !== $nextCursor && \count($resources) === $this->pageSize) {
            $result['nextCursor'] = $nextCursor;
        }

        return new Response($message->id, $result);
    }

    protected function supportedMethod(): string
    {
        return 'resources/list';
    }
}
