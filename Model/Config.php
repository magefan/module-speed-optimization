<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\SpeedOptimization\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const XML_MODULE_ENABLED = 'mfspeedoptimizations/general/enabled';

    /**
     * Enabled clean database
     */
    const XML_CLEAN_DATABASE_ENABLED = 'mfspeedoptimizations/database/clean_database_enabled';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve store config value
     * @param string $path
     * @param null $storeId
     * @return mixed
     */
    public function getConfig($path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Retrieve true if clean database is enabled
     *
     * @param null $storeId
     * @return bool
     */
    public function isCleanDatabaseEnabled($storeId = null): bool
    {
        return (bool)$this->getConfig(
            self::XML_CLEAN_DATABASE_ENABLED,
            $storeId
        );
    }

    /**
     * @param $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return (bool)$this->getConfig(
            self::XML_MODULE_ENABLED,
            $storeId
        );
    }
}
