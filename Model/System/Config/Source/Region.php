<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Aws\Model\System\Config\Source;

/**
 * Source model for AWS regions
 */
class Region
{
    /**
     * @var \ShopGo\Aws\Helper\AbstractHelper
     */
    protected $helper;

    /**
     * @var bool
     */
    protected $defaultRegion;

    /**
     * @var string
     */
    protected $serviceCode;

    /**
     * @param \ShopGo\Aws\Helper\AbstractHelper $helper
     * @param bool $defaultRegion
     * @param string $serviceCode
     */
    public function __construct(
        \ShopGo\Aws\Helper\AbstractHelper $helper,
        $defaultRegion = true,
        $serviceCode = ''
    ) {
        $this->helper = $helper;
        $this->defaultRegion = $defaultRegion;
        $this->serviceCode = $serviceCode;
    }

    /**
     * @param string $partition
     * @return array
     */
    public function toOptionArray($partition)
    {
        if (!$partition) {
            $partition = $this->helper->getAwsPartition();
            if (!$partition) {
                $defaultPartition = $this->helper->getAwsDefaultPartition();
                $partition = $defaultPartition['code'];
            }
        }

        if (!$this->defaultRegion) {
            $regions = $this->helper->getAwsServiceEndpoints($partition, $this->serviceCode);
        } else {
            $regions = $this->helper->getAwsPartitionRegions($partition);
        }

        $options = $regions
            ? [['value' => '', 'label' => __('--Please Select--')]]
            : [['value' => '', 'label' => __('-NO AVAILABLE REGIONS FOR THE SELECTED PARTITION-')]];

        foreach ($regions as $name => $value) {
            $options[] = ['value' => $name, 'label' => __($value['description'])];
        }

        return $options;
    }
}
