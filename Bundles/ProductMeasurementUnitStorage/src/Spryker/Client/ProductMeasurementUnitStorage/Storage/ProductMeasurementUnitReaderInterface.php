<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductMeasurementUnitStorage\Storage;

use Generated\Shared\Transfer\ProductMeasurementUnitTransfer;

interface ProductMeasurementUnitReaderInterface
{
    /**
     * @param int $idProductMeasurementUnit
     *
     * @return \Generated\Shared\Transfer\ProductMeasurementUnitTransfer|null
     */
    public function findProductMeasurementUnit(int $idProductMeasurementUnit): ?ProductMeasurementUnitTransfer;
}
