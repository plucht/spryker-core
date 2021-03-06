<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CustomerAccess\Business\Installer;

use Spryker\Zed\CustomerAccess\Business\CustomerAccess\CustomerAccessCreatorInterface;
use Spryker\Zed\CustomerAccess\Business\CustomerAccess\CustomerAccessReaderInterface;
use Spryker\Zed\CustomerAccess\CustomerAccessConfig;

class CustomerAccessInstaller implements CustomerAccessInstallerInterface
{
    /**
     * @var \Spryker\Zed\CustomerAccess\Business\CustomerAccess\CustomerAccessCreatorInterface
     */
    protected $customerAccessCreator;

    /**
     * @var \Spryker\Zed\CustomerAccess\CustomerAccessConfig
     */
    protected $customerAccessConfig;

    /**
     * @var \Spryker\Zed\CustomerAccess\Business\CustomerAccess\CustomerAccessReaderInterface
     */
    protected $customerAccessReader;

    /**
     * @param \Spryker\Zed\CustomerAccess\CustomerAccessConfig $customerAccessConfig
     * @param \Spryker\Zed\CustomerAccess\Business\CustomerAccess\CustomerAccessCreatorInterface $customerAccessCreator
     * @param \Spryker\Zed\CustomerAccess\Business\CustomerAccess\CustomerAccessReaderInterface $customerAccessReader
     */
    public function __construct(CustomerAccessConfig $customerAccessConfig, CustomerAccessCreatorInterface $customerAccessCreator, CustomerAccessReaderInterface $customerAccessReader)
    {
        $this->customerAccessCreator = $customerAccessCreator;
        $this->customerAccessReader = $customerAccessReader;
        $this->customerAccessConfig = $customerAccessConfig;
    }

    /**
     * @return void
     */
    public function install(): void
    {
        $defaultContentAccess = $this->customerAccessConfig->getContentTypeAccess();
        foreach ($this->customerAccessConfig->getContentTypes() as $contentType) {
            if ($this->customerAccessReader->findCustomerAccessByContentType($contentType) !== null) {
                continue;
            }

            $this->customerAccessCreator->createCustomerAccess($contentType, $defaultContentAccess);
        }
    }
}
