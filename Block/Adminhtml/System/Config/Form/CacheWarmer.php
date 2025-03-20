<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\SpeedOptimization\Block\Adminhtml\System\Config\Form;

class CacheWarmer extends Info
{
    /**
     * @return string
     */
    protected function getMinPlan(): string
    {
        return 'Extra';
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $planText = (!$this->getModuleVersion->execute($this->getModuleName() . $this->getMinPlan()))
            ? __('To enable <strong>Page Cache Warmer</strong> please update to %1 or install %2.',
                '<a href="#"><strong>Page Speed Optimization Extra</strong></a>',
                '<a rel="noopener" target="_blank" href="https://magefan.com/magento-2-full-page-cache-warmer"><strong>Magento 2 Page Cache Warmer</strong></a>')
            : __('To enable <strong>Page Cache Warmer</strong> please navigate to')
                . '<a href="' . $this->escapeHtml($this->getUrl('*/*/*', ['section' => 'mfpagecachewarmer'])) . '" target="_blank"> <strong>Stores > Configuration > Magefan Extensions > Cache Warmer</strong></a>.';

        $html =
            '<div>'
                . __('Keep the server response time for the main document short because all other requests depend on it.') . '<br/>'
                . $planText .
            '</div>';
        return $html;
    }
}
