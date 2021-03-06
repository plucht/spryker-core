<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CustomersRestApi\Processor\Customers;

use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\CustomersRestApi\CustomersRestApiConfig;
use Spryker\Glue\CustomersRestApi\Dependency\Client\CustomersRestApiToCustomerClientInterface;
use Spryker\Glue\CustomersRestApi\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CustomerPasswordWriter implements CustomerPasswordWriterInterface
{
    /**
     * @var \Spryker\Glue\CustomersRestApi\Dependency\Client\CustomersRestApiToCustomerClientInterface
     */
    protected $customerClient;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \Spryker\Glue\CustomersRestApi\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface
     */
    protected $customerRestorePasswordResourceMapper;

    /**
     * @param \Spryker\Glue\CustomersRestApi\Dependency\Client\CustomersRestApiToCustomerClientInterface $customerClient
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Spryker\Glue\CustomersRestApi\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface $customerRestorePasswordResourceMapper
     */
    public function __construct(
        CustomersRestApiToCustomerClientInterface $customerClient,
        RestResourceBuilderInterface $restResourceBuilder,
        CustomerRestorePasswordResourceMapperInterface $customerRestorePasswordResourceMapper
    ) {
        $this->customerClient = $customerClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->customerRestorePasswordResourceMapper = $customerRestorePasswordResourceMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function restorePassword(RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer): RestResponseInterface
    {
        $response = $this->restResourceBuilder->createRestResponse();

        $customerTransfer = $this->customerRestorePasswordResourceMapper
            ->mapCustomerRestorePasswordAttributesToCustomerTransfer($restCustomerRestorePasswordAttributesTransfer);
        $customerResponseTransfer = $this->customerClient->restorePassword($customerTransfer);

        if (!$customerResponseTransfer->getIsSuccess()) {
            return $response->addError($this->createErrorRestorePasswordKeyIsNotValid());
        }

        return $response->setStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @return \Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    protected function createErrorRestorePasswordKeyIsNotValid(): RestErrorMessageTransfer
    {
        return (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_RESTORE_PASSWORD_KEY_INVALID)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(CustomersRestApiConfig::RESPONSE_DETAILS_RESTORE_PASSWORD_KEY_INVALID);
    }
}
