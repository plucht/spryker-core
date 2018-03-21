<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesReclamation\Communication\Table;

use Orm\Zed\SalesReclamation\Persistence\Map\SpySalesReclamationTableMap;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Spryker\Zed\SalesReclamation\Dependency\Service\SalesReclamationToUtilDateTimeServiceInterface;
use Spryker\Zed\SalesReclamation\Persistence\SalesReclamationQueryContainerInterface;

class ReclamationTable extends AbstractTable
{
    /**
     * @var \Spryker\Zed\SalesReclamation\Persistence\SalesReclamationQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \Spryker\Zed\SalesReclamation\Dependency\Service\SalesReclamationToUtilDateTimeServiceInterface
     */
    protected $dateTimeService;

    /**
     * @param \Spryker\Zed\SalesReclamation\Persistence\SalesReclamationQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\SalesReclamation\Dependency\Service\SalesReclamationToUtilDateTimeServiceInterface $dateTimeService
     */
    public function __construct(
        SalesReclamationQueryContainerInterface $queryContainer,
        SalesReclamationToUtilDateTimeServiceInterface $dateTimeService
    ) {
        $this->queryContainer = $queryContainer;
        $this->dateTimeService = $dateTimeService;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader($this->getHeaderFields());

        $config->addRawColumn(SpySalesReclamationTableMap::COL_STATE);

        return $config;
    }

    /**
     * @return array
     */
    protected function getHeaderFields()
    {
        return [
            SpySalesReclamationTableMap::COL_ID_SALES_RECLAMATION => '#',
            SpySalesReclamationTableMap::COL_CREATED_AT => 'Created',
            SpySalesReclamationTableMap::COL_CUSTOMER_NAME => 'Customer',
            SpySalesReclamationTableMap::COL_STATE => 'State',
            SpySalesReclamationTableMap::COL_FK_SALES_ORDER => 'Order id',
        ];
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $query = $this->queryContainer->queryReclamations();
        $queryResults = $this->runQuery($query, $config);

        return $this->formatQueryData($queryResults);
    }

    /**
     * @param array $queryResults
     *
     * @return array
     */
    protected function formatQueryData(array $queryResults)
    {
        $results = [];
        foreach ($queryResults as $item) {
            $results[] = [
                SpySalesReclamationTableMap::COL_ID_SALES_RECLAMATION => $item[SpySalesReclamationTableMap::COL_ID_SALES_RECLAMATION],
                SpySalesReclamationTableMap::COL_CREATED_AT => $this->dateTimeService->formatDateTime(
                    $item[SpySalesReclamationTableMap::COL_CREATED_AT]
                ),
                SpySalesReclamationTableMap::COL_CUSTOMER_NAME => $item[SpySalesReclamationTableMap::COL_CUSTOMER_NAME],
                SpySalesReclamationTableMap::COL_STATE => $this->createStatusLabel(
                    $item[SpySalesReclamationTableMap::COL_STATE]
                ),
                SpySalesReclamationTableMap::COL_FK_SALES_ORDER => $item[SpySalesReclamationTableMap::COL_FK_SALES_ORDER],
            ];
        }

        return $results;
    }

    /**
     * @param string $state
     *
     * @return string
     */
    public function createStatusLabel(string $state): string
    {
        $statusLabel = '';
        switch ($state) {
            case SpySalesReclamationTableMap::COL_STATE_OPEN:
                $statusLabel = '<span class="label label-success" title="Active">Open</span>';
                break;
            case SpySalesReclamationTableMap::COL_STATE_CLOSE:
                $statusLabel = '<span class="label label-danger" title="Deactivated">Closed</span>';
                break;
        }

        return $statusLabel;
    }
}
