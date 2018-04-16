<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MultiCart\Zed;

use Generated\Shared\Transfer\QuoteActivationRequestTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\MultiCart\Dependency\Client\MultiCartToZedRequestClientInterface;

class MultiCartZedStub implements MultiCartZedStubInterface
{
    /**
     * @var \Spryker\Client\MultiCart\Dependency\Client\MultiCartToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\MultiCart\Dependency\Client\MultiCartToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(MultiCartToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteActivationRequestTransfer $quoteActivationRequestTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface|\Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function setDefaultQuote(QuoteActivationRequestTransfer $quoteActivationRequestTransfer): QuoteResponseTransfer
    {
        return $this->zedRequestClient->call('/multi-cart/gateway/set-default-quote', $quoteActivationRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface|\Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function duplicateQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->zedRequestClient->call('/multi-cart/gateway/duplicate-quote', $quoteTransfer);
    }
}