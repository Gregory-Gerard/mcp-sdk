<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\McpSdk\Exception;

use Symfony\AI\McpSdk\Capability\Tool\ToolCall;

final class ToolNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    /**
     * @readonly
     */
    public ToolCall $toolCall;

    public function __construct(
        ToolCall $toolCall
    ) {
        $this->toolCall = $toolCall;
        parent::__construct(\sprintf('Tool not found for call: "%s"', $toolCall->name));
    }
}
