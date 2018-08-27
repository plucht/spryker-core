<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Development\Business\Module\PathBuilder;

class SprykerEcoModulePathBuilder extends AbstractPathBuilder
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $module
     *
     * @return array
     */
    public function buildPaths(string $module): array
    {
        $paths = [
            sprintf('%s%s/', $this->basePath, $module),
        ];

        return $paths;
    }
}
