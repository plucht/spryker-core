<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Checkout;

use Spryker\Zed\Checkout\Dependency\Facade\CheckoutToOmsFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CheckoutDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CHECKOUT_PRE_CONDITIONS = 'checkout_pre_conditions';
    public const CHECKOUT_POST_HOOKS = 'checkout_post_hooks';
    public const CHECKOUT_ORDER_SAVERS = 'checkout_order_savers';
    public const CHECKOUT_PRE_SAVE_HOOKS = 'checkout_pre_save_hooks';
    public const FACADE_OMS = 'FACADE_OMS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[self::CHECKOUT_PRE_CONDITIONS] = function (Container $container) {
            return $this->getCheckoutPreConditions($container);
        };

        $container[self::CHECKOUT_ORDER_SAVERS] = function (Container $container) {
            return $this->getCheckoutOrderSavers($container);
        };

        $container[self::CHECKOUT_POST_HOOKS] = function (Container $container) {
            return $this->getCheckoutPostHooks($container);
        };

        $container[static::CHECKOUT_PRE_SAVE_HOOKS] = function (Container $container) {
            return $this->getCheckoutPreSaveHooks($container);
        };

        $container = $this->addOmsFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOmsFacade(Container $container)
    {
        $container[static::FACADE_OMS] = function () use ($container) {
            return new CheckoutToOmsFacadeBridge($container->getLocator()->oms()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreConditionInterface[]
     */
    protected function getCheckoutPreConditions(Container $container)
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Checkout\Dependency\Plugin\CheckoutSaveOrderInterface[]
     */
    protected function getCheckoutOrderSavers(Container $container)
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPostSaveHookInterface[]
     */
    protected function getCheckoutPostHooks(Container $container)
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveHookInterface[]|\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveInterface[]
     */
    protected function getCheckoutPreSaveHooks(Container $container)
    {
        return [];
    }
}
