<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Discount\Communication\Plugin\Collector;

use Generated\Shared\Transfer\DiscountCollectorTransfer;
use Generated\Shared\Transfer\DiscountTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Discount\Business\DiscountFacade;
use Spryker\Zed\Discount\Business\Model\DiscountableInterface;
use Spryker\Zed\Discount\Communication\Plugin\AbstractDiscountPlugin;
use Spryker\Zed\Discount\Dependency\Plugin\DiscountCollectorPluginInterface;

/**
 * @method \Spryker\Zed\Discount\Business\DiscountFacade getFacade()
 */
class Item extends AbstractDiscountPlugin implements DiscountCollectorPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discount
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\DiscountCollectorTransfer $discountCollectorTransfer
     *
     * @return \Spryker\Zed\Discount\Business\Model\DiscountableInterface[]
     */
    public function collect(
        DiscountTransfer $discount,
        QuoteTransfer $quoteTransfer,
        DiscountCollectorTransfer $discountCollectorTransfer
    ) {
        return $this->getFacade()->getDiscountableItems($quoteTransfer, $discountCollectorTransfer);
    }

}
