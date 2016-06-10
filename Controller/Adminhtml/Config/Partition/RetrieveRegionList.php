<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Aws\Controller\Adminhtml\Config\Partition;

class RetrieveRegionList extends \ShopGo\Aws\Controller\Adminhtml\Config\AbstractAction
{
    /**
     * AWS region system config source
     *
     * @var \ShopGo\Aws\Model\System\Config\Source\Region
     */
    protected $region;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \ShopGo\Aws\Model\System\Config\Source\Region $region
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \ShopGo\Aws\Model\System\Config\Source\Region $region
    ) {
        $this->region = $region;
        parent::__construct($context);
    }

    /**
     * Retrieve AWS region list action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $partition = $this->getRequest()->getParam('partition');
        $response  = $this->getResponse()->setHeader(
            'content-type',
            'application/json; charset=utf-8'
        );

        $result = [
            'status' => 0,
            'description' => __(
                'AWS partition is required in order to retrieve region list.'
            )
        ];

        if (!$partition) {
            return $result;
        }

        $awsPartitionRegions = $this->region->toOptionArray($partition);

        if ($awsPartitionRegions) {
            $result = [
                'status' => 1,
                'description' => __('AWS region list has been retrieved successfully!'),
                'data' => $awsPartitionRegions
            ];
        } else {
            $result['description'] = __(
                'Could not retrieve AWS region list.'
                . ' if the issue persists, please report this issue to the module author.'
            );
        }

        $response->setBody(json_encode($result));
    }
}
