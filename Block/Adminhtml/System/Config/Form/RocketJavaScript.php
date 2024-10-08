<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\SpeedOptimization\Block\Adminhtml\System\Config\Form;

class RocketJavaScript extends Info
{
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html =
            '<div>'
                . __('Consider reducing the time spent parsing, compiling, and executing JS.') . '<br/>'
                . __('To configure <strong>JavaScript Optimization</strong> please navigate to')
                . ' <a href="' . $this->escapeHtml($this->getUrl('*/*/*', ['section' => 'mfrocketjavascript'])) . '" target="_blank"> <strong>Stores > Configuration > Magefan Extensions > Rocket JavaScript</strong></a>.
        <div>';

        return $html;
    }
}
