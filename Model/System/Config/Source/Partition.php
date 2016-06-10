<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Aws\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Source model for AWS partitions
 */
class Partition implements ArrayInterface
{
    /**
     * @var \ShopGo\Aws\Helper\Data
     */
    protected $helper;

    /**
     * @param \ShopGo\Aws\Helper\Data $helper
     */
    public function __construct(
        \ShopGo\Aws\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $partitions = [];

        foreach ($this->helper->getAwsEndpointsPartitions() as $name => $value) {
            $partitions[] = ['value' => $name, 'label' => __($value['partitionName'])];
        }

        if (!$partitions) {
            $defaultPartition = $this->helper->getAwsDefaultPartition();
            $partitions[] = [
                'value' => $defaultPartition['code'],
                'label' => __($defaultPartition['name'])
            ];
        }

        return $partitions;
    }
}
