<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Application\Business\Model\Navigation\Extractor;

interface PathExtractorInterface
{

    /**
     * @param array $menu
     *
     * @return array
     */
    public function extractPathFromMenu(array $menu);

}