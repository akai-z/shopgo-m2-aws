<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Aws\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Aws\Common\Enum\Region as AwsRegion;

/**
 * Source model for AWS regions
 */
class Region implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '', 'label' => __('--Please Select--')],
            ['value' => AwsRegion::NORTHERN_VIRGINIA, 'label' => __('US East (Northen Verginia)')],
            ['value' => AwsRegion::NORTHERN_CALIFORNIA, 'label' => __('US West (Northen California)')],
            ['value' => AwsRegion::OREGON, 'label' => __('US West (Oregon)')],
            ['value' => AwsRegion::IRELAND, 'label' => __('EU (Ireland)')],
            ['value' => AwsRegion::FRANKFURT, 'label' => __('EU (Frankfurt)')],
            ['value' => AwsRegion::TOKYO, 'label' => __('Asia Pacific (Tokyo)')],
            ['value' => 'ap-northeast-2', 'label' => __('Asia Pacific (Seoul)')],
            ['value' => AwsRegion::SINGAPORE, 'label' => __('Asia Pacific (Singapore)')],
            ['value' => AwsRegion::SYDNEY, 'label' => __('Asia Pacific (Sydney)')],
            ['value' => AwsRegion::SAO_PAULO, 'label' => __('South America (São Paulo)')]
        ];
    }
}
