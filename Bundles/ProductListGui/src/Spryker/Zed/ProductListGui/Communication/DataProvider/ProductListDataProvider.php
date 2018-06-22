<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductListGui\Communication\DataProvider;

use Generated\Shared\Transfer\ProductListTransfer;
use Spryker\Zed\ProductListGui\Communication\Form\ProductListForm;
use Spryker\Zed\ProductListGuiExtension\Dependency\Plugin\ProductListCreateFormExpanderPluginInterface;

class ProductListDataProvider
{
    /**
     * @var \Spryker\Zed\ProductListGui\Communication\DataProvider\CategoryDataProvider
     */
    protected $categoryDataProvider;

    /**
     * @var \Spryker\Zed\ProductListGui\Communication\DataProvider\ProductListProductConcreteRelationDataProvider
     */
    protected $productConcreteRelationDataProvider;

    /**
     * @var \Spryker\Zed\ProductListGuiExtension\Dependency\Plugin\ProductListCreateFormExpanderPluginInterface[]
     */
    private $productListCreateFormExpanderPlugins;

    /**
     * @param \Spryker\Zed\ProductListGui\Communication\DataProvider\CategoryDataProvider $categoryDataProvider
     * @param \Spryker\Zed\ProductListGui\Communication\DataProvider\ProductListProductConcreteRelationDataProvider $productConcreteRelationDataProvider
     * @param \Spryker\Zed\ProductListGuiExtension\Dependency\Plugin\ProductListCreateFormExpanderPluginInterface[] $productListCreateFormExpanderPlugins
     */
    public function __construct(
        CategoryDataProvider $categoryDataProvider,
        ProductListProductConcreteRelationDataProvider $productConcreteRelationDataProvider,
        ProductListCreateFormExpanderPluginInterface ... $productListCreateFormExpanderPlugins
    ) {
        $this->categoryDataProvider = $categoryDataProvider;
        $this->productConcreteRelationDataProvider = $productConcreteRelationDataProvider;
        $this->productListCreateFormExpanderPlugins = $productListCreateFormExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer|null $productListTransfer
     *
     * @return array
     */
    public function getOptions(?ProductListTransfer $productListTransfer = null): array
    {
        $options = [
            ProductListForm::FIELD_CATEGORIES => $this->categoryDataProvider->getOptions(),
            ProductListForm::FIELD_PRODUCTS => $this->productConcreteRelationDataProvider->getOptions(),
            ProductListForm::OPTION_DISABLE_GENERAL => $productListTransfer && $productListTransfer->getIdProductList(),
            ProductListForm::OPTION_OWNER_TYPES => [],
        ];

        return $this->updateOptions($options);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListTransfer
     */
    public function getData(ProductListTransfer $productListTransfer): ProductListTransfer
    {
        return $productListTransfer;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function updateOptions(array $options): array
    {
        foreach ($this->productListCreateFormExpanderPlugins as $productListCreateFormExpanderPlugin) {
            $options = $productListCreateFormExpanderPlugin->getOptions($options);
        }

        return $options;
    }
}
