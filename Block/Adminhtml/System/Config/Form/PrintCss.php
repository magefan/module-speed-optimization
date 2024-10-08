<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\SpeedOptimization\Block\Adminhtml\System\Config\Form;

class PrintCss extends Info
{
    /**
     * @return string
     */
    protected function getMinPlan(): string
    {
        return 'Plus';
    }

    /**
     * @return string
     */
    protected function getSectionId(): string
    {
        return 'mfspeedoptimizations_css_move_print_css_to_bottom';
    }

    /**
     * Return info block html
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        if ($this->getModuleVersion->execute($this->getModuleName() . $this->getMinPlan())) {
            return '';
        }

        $html = '<script>
                require(["jquery", "Magento_Ui/js/modal/alert", "domReady!"], function($, alert){
                    setInterval(function() {
                        var $plusSection = $("#row_' . $this->getSectionId() . '");
                        $plusSection.find(".use-default").css("visibility", "hidden");
                        $plusSection.find("input,select").each(function(){
                            $(this).attr("readonly", "readonly");
                            $(this).removeAttr("disabled");
                            if ($(this).data("psodisabled")) return;
                            $(this).data("psodisabled", 1);
                            $(this).click(function(){
                                alert({
                                    title: "' . __("You cannot change this option.") . '",
                                    content: "' .
                                        (
                                        ($this->getMinPlan() == 'Extra')
                                            ? __('This option is available in <strong>Extra</strong> plan only.')
                                            : __('This option is available in <strong>Plus or Extra</strong> plans only.')
                                        )
                                        . '",
                                    buttons: [{
                                        text: "' . __("Upgrade Plan Now") . '",
                                        class: "action primary accept",
                                        click: function () {
                                            window.open("https://magefan.com/magento-2-page-speed-optimization/pricing?utm_source=gtm_config&utm_medium=link&utm_campaign=regular");
                                        }
                                    }]
                                });
                            });
                        });
                    }, 1000);
                });
            </script>';

        return $html;
    }
}
