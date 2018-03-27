<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PersistentCart\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PersistentCart\Business\Model\CartChangeRequestExpander;
use Spryker\Zed\PersistentCart\Business\Model\CartOperation;
use Spryker\Zed\PersistentCart\Business\Model\QuoteDeleter;
use Spryker\Zed\PersistentCart\Business\Model\QuoteMerger;
use Spryker\Zed\PersistentCart\Business\Model\QuoteResponseExpander;
use Spryker\Zed\PersistentCart\Business\Model\QuoteStorageSynchronizer;
use Spryker\Zed\PersistentCart\Business\Model\QuoteWriter;
use Spryker\Zed\PersistentCart\PersistentCartDependencyProvider;

class PersistentCartBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\CartOperationInterface
     */
    public function createCartOperation()
    {
        return new CartOperation(
            $this->getCartFacade(),
            $this->getQuoteFacade(),
            $this->getQuoteItemFinderPlugin(),
            $this->createCartChangeRequestExpander(),
            $this->createQuoteResponseExpander()
        );
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\QuoteStorageSynchronizerInterface
     */
    public function createQuoteStorageSynchronizer()
    {
        return new QuoteStorageSynchronizer(
            $this->getCartFacade(),
            $this->getQuoteFacade(),
            $this->createQuoteResponseExpander(),
            $this->createQuoteMerger()
        );
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\QuoteDeleterInterface
     */
    public function createQuoteDeleter()
    {
        return new QuoteDeleter(
            $this->getQuoteFacade(),
            $this->createQuoteResponseExpander()
        );
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\QuoteWriterInterface
     */
    public function createQuoteWriter()
    {
        return new QuoteWriter(
            $this->getQuoteFacade(),
            $this->createQuoteResponseExpander()
        );
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\QuoteResponseExpanderInterface
     */
    public function createQuoteResponseExpander()
    {
        return new QuoteResponseExpander(
            $this->getQuoteResponseExpanderPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\CartChangeRequestExpanderInterface
     */
    public function createCartChangeRequestExpander()
    {
        return new CartChangeRequestExpander(
            $this->getRemoveItemsRequestExpanderPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Business\Model\QuoteMergerInterface
     */
    public function createQuoteMerger()
    {
        return new QuoteMerger();
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Dependency\Plugin\QuoteItemFinderPluginInterface
     */
    protected function getQuoteItemFinderPlugin()
    {
        return $this->getProvidedDependency(PersistentCartDependencyProvider::PLUGIN_QUOTE_ITEM_FINDER);
    }

    /**
     * @return \Spryker\Client\Cart\Dependency\Plugin\CartChangeRequestExpanderPluginInterface[]
     */
    protected function getRemoveItemsRequestExpanderPlugins()
    {
        return $this->getProvidedDependency(PersistentCartDependencyProvider::PLUGINS_REMOVE_ITEMS_REQUEST_EXPANDER);
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToCartFacadeInterface
     */
    protected function getCartFacade()
    {
        return $this->getProvidedDependency(PersistentCartDependencyProvider::FACADE_CART);
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Dependency\Facade\PersistentCartToQuoteFacadeInterface
     */
    protected function getQuoteFacade()
    {
        return $this->getProvidedDependency(PersistentCartDependencyProvider::FACADE_QUOTE);
    }

    /**
     * @return \Spryker\Zed\PersistentCart\Dependency\Plugin\QuoteResponseExpanderPluginInterface[]
     */
    protected function getQuoteResponseExpanderPlugins()
    {
        return $this->getProvidedDependency(PersistentCartDependencyProvider::PLUGINS_QUOTE_RESPONSE_EXPANDER);
    }
}
