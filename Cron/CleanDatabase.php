<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\SpeedOptimization\Cron;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magefan\SpeedOptimization\Model\Config;

class CleanDatabase
{

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CleanDatabase constructor.
     * @param ResourceConnection $resource
     * @param Config $config
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceConnection $resource,
        Config $config,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Execute the cron
     *
     * @throws \Zend_Db_Statement_Exception
     * @return void
     */
    public function execute()
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        if (!$this->config->isCleanDatabaseEnabled()) {
            return;
        }

        $pastDate = date('Y-m-d H:i:s', time() - 30 * 86400);

        $this->resource->getConnection()->delete(
            $this->resource->getTableName('report_event'),
            ['logged_at < ?' => $pastDate]
        );

        $this->resource->getConnection()->delete(
            $this->resource->getTableName('report_viewed_product_index'),
            ['added_at < ?' => $pastDate]
        );


        $this->resource->getConnection()->delete(
            $this->resource->getTableName('quote'),
            [
                'customer_id IS NULL',
                'customer_email IS NULL',
                'reserved_order_id IS NULL',
                'updated_at < ?' => $pastDate
            ]
        );

        $yearAgoDate = date('Y-m-d H:i:s', time() - 365 * 86400);
        $this->resource->getConnection()->delete(
            $this->resource->getTableName('search_query'),
            [
                'updated_at < ?' => $yearAgoDate,
                'num_results = ?' => 0
            ]
        );

        $this->resource->getConnection()->delete(
            $this->resource->getTableName('search_query'),
            [
                'updated_at < ?' => $yearAgoDate,
                'popularity < ?' => 3
            ]
        );

        $this->resource->getConnection()->delete(
            $this->resource->getTableName('search_query'),
            [
                'LENGTH(query_text) < ?' => 3
            ]
        );

        $this->resource->getConnection()->delete(
            $this->resource->getTableName('search_query'),
            [
                'query_text LIKE ?' => '%=%'
            ]
        );

        $this->resource->getConnection()->delete(
            $this->resource->getTableName('search_query'),
            [
                'query_text LIKE ?' => '%&%'
            ]
        );

        $this->resource->getConnection()->delete(
            $this->resource->getTableName('search_query'),
            [
                'updated_at < ?' => date('Y-m-d H:i:s', time() - 365 * 86400 * 4),
            ]
        );

        if ($this->resource->getConnection()->isTableExists($this->resource->getTableName('kiwicommerce_activity'))) {
            $this->resource->getConnection()->delete(
                $this->resource->getTableName('kiwicommerce_activity'),
                [
                    'updated_at < ?' => date('Y-m-d H:i:s', time() - 30 * 86400),
                ]
            );
        }

        if ($this->resource->getConnection()->isTableExists($this->resource->getTableName('kiwicommerce_login_activity'))) {
            $this->resource->getConnection()->delete(
                $this->resource->getTableName('kiwicommerce_login_activity'),
                [
                    'created_at < ?' => date('Y-m-d H:i:s', time() - 30 * 86400),
                ]
            );
        }

        if ($this->resource->getConnection()->isTableExists($this->resource->getTableName('mst_search_report_log'))) {
            $this->resource->getConnection()->delete(
                $this->resource->getTableName('mst_search_report_log'),
                [
                    'created_at < ?' => $yearAgoDate,
                    'results = ?' => 0
                ]
            );

            $this->resource->getConnection()->delete(
                $this->resource->getTableName('mst_search_report_log'),
                [
                    'LENGTH(query) < ?' => 3
                ]
            );

            $this->resource->getConnection()->delete(
                $this->resource->getTableName('mst_search_report_log'),
                [
                    'created_at < ?' => date('Y-m-d H:i:s', time() - 365 * 86400 * 2),
                ]
            );
        }
    }

    /**
     * Execute the cron to clean tables with _cl ending
     *
     * @return void
     */
    public function cleanClTables()
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        if (!$this->config->isCleanDatabaseEnabled()) {
            return;
        }

        $connection = $this->resource->getConnection();

        $tablesToTruncate = $connection->fetchAll(
            $connection->select()
                ->from($connection->getTableName('mview_state'))
                ->where('version_id != ?', 0)
        );

        foreach ($tablesToTruncate as $table) {
            if ($table['view_id']) {
                $connection->truncateTable($table['view_id'] . '_cl');
                $this->logger->info('Truncated Table - ' .  $table['view_id'] . '_cl');
            }
        }
    }
}
