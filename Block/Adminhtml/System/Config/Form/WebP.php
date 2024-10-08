<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\SpeedOptimization\Block\Adminhtml\System\Config\Form;

class WebP extends Info
{
    /**
     * @return string
     */
    protected function getMinPlan(): string
    {
        return 'Plus';
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $planText = !$this->getModuleVersion->execute($this->getModuleName() . $this->getMinPlan())
            ? __('To enable <strong>WebP Images</strong> please update to %1 or install %2.',
                '<a href="#"><strong>Page Speed Optimization Plus/Extra</strong></a>',
                '<a rel="noopener" target="_blank" href="https://magefan.com/magento-2-webp-optimized-images"><strong>Magento 2 WebP Extension</strong></a>')
            : __('To enable <strong>WebP Images</strong> please navigate to %1.',
                '<a href="' . $this->escapeHtml($this->getUrl('*/*/*', ['section' => 'mfwebp'])) . '" target="_blank"> <strong>Stores > Configuration > Magefan Extensions > WebP Optimized Images</strong></a>');

        $html = '';

        $html .=
            '<div>'
                . __('Image formats like WebP provide better compression than PNG or JPEG, which means faster downloads and less data consumption.') .'<br/>'
                . $planText . '<br/>'
                . __('Learn more about') . ' <a rel="noopener" target="_blank" href="https://developers.google.com/speed/webp/">modern WebP image format</a>.
            </div>';
        return $html;
    }
}
