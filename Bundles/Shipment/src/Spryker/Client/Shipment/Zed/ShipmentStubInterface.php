<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Client\Shipment\Zed;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentMethodsTransfer;

interface ShipmentStubInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ShipmentMethodsTransfer
     */
    public function getAvailableMethods(QuoteTransfer $quoteTransfer);

}
