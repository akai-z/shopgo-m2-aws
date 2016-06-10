<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShopGo\Aws\Block\Adminhtml\System\Config;

class Partition extends \Magento\Backend\Block\Template
{
    /**
     * @var string
     */
    protected $systemConfigSection;

    /**
     * @var string
     */
    protected $configFieldIdPrefix;

    /**
     * @var string
     */
    protected $regionListAjaxUrl;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param string $systemConfigSection
     * @param string $configFieldIdPrefix
     * @param string $regionListAjaxUrl
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        $systemConfigSection = 'aws',
        $configFieldIdPrefix = 'aws_general',
        $regionListAjaxUrl = 'aws/config_partition/retrieveregionlist',
        array $data = []
    ) {
        $this->systemConfigSection = $systemConfigSection;
        $this->configFieldIdPrefix = $configFieldIdPrefix;
        $this->regionListAjaxUrl = $regionListAjaxUrl;

        parent::__construct($context, $data);
    }

    /**
     * Check whether JS code can be added for the current loaded page
     *
     * @return bool
     */
    public function isActive()
    {
        $result = false;
        $systemConfigSection = $this->getRequest()->getParam('section');

        if ($this->systemConfigSection == $systemConfigSection) {
            $result = true;
        }

        return $result;
    }

    /**
     * Get system config field ID prefix
     *
     * @return string
     */
    public function getConfigFieldIdPrefix()
    {
        return $this->configFieldIdPrefix;
    }

    /**
     * Get region list Ajax URL
     *
     * @return string
     */
    public function getRegionListAjaxUrl()
    {
        return $this->_urlBuilder->getUrl($this->regionListAjaxUrl);
    }
}
