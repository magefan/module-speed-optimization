<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\SpeedOptimization\Block\Adminhtml\System\Config\Form;

class LazyLoad extends Info
{
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '<div>' .
            __('Consider lazy-loading offscreen and hidden images after all critical resources have finished loading to lower time to interactive<br/>
                To enable <strong>Image Lazy Loading</strong> please navigate to')
            . '<a href="' . $this->escapeHtml($this->getUrl('*/*/*', ['section' => 'mflazyzoad'])) . '" target="_blank">
                <strong>Stores > Configuration > Magefan Extensions > Image Lazy Load</strong>
            </a>.
        </div>';

        return $html;
    }
}
