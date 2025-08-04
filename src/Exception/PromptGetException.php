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

use Symfony\AI\McpSdk\Capability\Prompt\PromptGet;

final class PromptGetException extends \RuntimeException implements ExceptionInterface
{
    /**
     * @readonly
     */
    public PromptGet $promptGet;

    public function __construct(
        PromptGet $promptGet,
        ?\Throwable $previous = null
    ) {
        $this->promptGet = $promptGet;
        parent::__construct(\sprintf('Handling prompt "%s" failed with error: %s', $promptGet->name, $previous->getMessage()), 0, $previous);
    }
}
