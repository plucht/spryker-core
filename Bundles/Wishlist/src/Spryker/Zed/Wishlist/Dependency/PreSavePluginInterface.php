<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Wishlist\Dependency;

use Generated\Shared\Transfer\ItemTransfer;

interface PreSavePluginInterface
{

    /**
     * @param \ArrayObject|ItemTransfer[] $items
     */
    public function trigger(\ArrayObject $items);

}