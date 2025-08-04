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

final class PromptNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    /**
     * @readonly
     */
    public PromptGet $promptGet;

    public function __construct(
        PromptGet $promptGet
    ) {
        $this->promptGet = $promptGet;
        parent::__construct(\sprintf('Prompt not found for name: "%s"', $promptGet->name));
    }
}
