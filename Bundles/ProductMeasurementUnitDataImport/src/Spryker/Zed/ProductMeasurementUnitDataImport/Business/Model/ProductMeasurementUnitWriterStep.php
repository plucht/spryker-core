<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMeasurementUnitDataImport\Business\Model;

use Orm\Zed\ProductMeasurementUnit\Persistence\SpyProductMeasurementUnit;
use Orm\Zed\ProductMeasurementUnit\Persistence\SpyProductMeasurementUnitQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\ProductMeasurementUnit\Dependency\ProductMeasurementUnitEvents;

class ProductMeasurementUnitWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    protected const  DEFAULT_PRECISION = 1;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $productMeasurementUnitEntity = $this->saveProductMeasurementUnit($dataSet);

        $this->addPublishEvents(
            ProductMeasurementUnitEvents::PRODUCT_MEASUREMENT_UNIT_PUBLISH,
            $productMeasurementUnitEntity->getIdProductMeasurementUnit()
        );
    }

    /**
     * @param string $defaultPrecision
     *
     * @return int
     */
    protected function filterDefaultPrecision($defaultPrecision): int
    {
        if ($defaultPrecision === "") {
            return static::DEFAULT_PRECISION;
        }

        return (int)$defaultPrecision;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\ProductMeasurementUnit\Persistence\SpyProductMeasurementUnit
     */
    protected function saveProductMeasurementUnit(DataSetInterface $dataSet): SpyProductMeasurementUnit
    {
        $productMeasurementUnitEntity = SpyProductMeasurementUnitQuery::create()
            ->filterByCode($dataSet[ProductMeasurementUnitDataSet::COLUMN_CODE])
            ->findOneOrCreate();

        $productMeasurementUnitEntity
            ->setName($dataSet[ProductMeasurementUnitDataSet::COLUMN_NAME])
            ->setDefaultPrecision($this->filterDefaultPrecision($dataSet[ProductMeasurementUnitDataSet::COLUMN_DEFAULT_PRECISION]))
            ->save();
        return $productMeasurementUnitEntity;
    }
}
