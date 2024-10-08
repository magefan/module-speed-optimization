<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
declare(strict_types=1);

namespace Magefan\SpeedOptimization\Model\Config\Backend;

use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface as StoreScopeInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

class DevSettings extends Value
{
    const KEY_VALUE_RELATION = [
        'mfspeedoptimizations/css/merge_css_files' => 'dev/css/merge_css_files',
        'mfspeedoptimizations/css/minify_files' => 'dev/css/minify_files',

        'mfspeedoptimizations/html/minify_html' => 'dev/template/minify_html',

        'mfspeedoptimizations/database/flat_catalog_category' => 'catalog/frontend/flat_catalog_category',
        'mfspeedoptimizations/database/flat_catalog_product' => 'catalog/frontend/flat_catalog_product',
    ];

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * DevSettings constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param RequestInterface $request
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        RequestInterface $request,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->request = $request;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * @return DevSettings|void
     */
    public function afterLoad()
    {
        $scopeTypes = [
            StoreScopeInterface::SCOPE_WEBSITES,
            StoreScopeInterface::SCOPE_WEBSITE,
            StoreScopeInterface::SCOPE_STORES,
            StoreScopeInterface::SCOPE_STORE
        ];

        $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $scopeCode = null;

        foreach ($scopeTypes as $scope) {
            $param = $this->request->getParam($scope);
            if ($param) {
                $scopeType = $scope;
                $scopeCode = $param;
            }
        }

        $devSettingsValue = $this->_config->getValue(
            self::KEY_VALUE_RELATION[$this->getData('path')],
            $scopeType,
            $scopeCode
        );
        $this->setData('value', $devSettingsValue);
    }
}