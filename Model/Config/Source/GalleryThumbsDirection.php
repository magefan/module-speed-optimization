<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\SpeedOptimization\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class GalleryThumbsDirection implements OptionSourceInterface
{
    const VERTICAL = 'vertical';
    const HORIZONTAL = 'horizontal';

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Vertical'),
                'value' => self::VERTICAL
            ],
            [
                'label' => __('Horizontal'),
                'value' => self::HORIZONTAL
            ]
        ];
    }
}
