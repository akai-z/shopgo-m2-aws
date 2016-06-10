<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Aws\Helper;

abstract class AbstractHelper extends \ShopGo\Core\Helper\AbstractHelper
{
    /**
     * Default AWS version
     */
    const AWS_VERSION = 'latest';

    /**
     * XML path AWS general version
     */
    const XML_PATH_AWS_GENERAL_VERSION = 'aws/general/version';

    /**
     * XML path AWS general region
     */
    const XML_PATH_AWS_GENERAL_REGION = 'aws/general/region';

    /**
     * XML path credentials AWS key
     */
    const XML_PATH_CREDENTIALS_AWS_KEY = 'aws/credentials/aws_key';

    /**
     * XML path credentials AWS secret
     */
    const XML_PATH_CREDENTIALS_AWS_SECRET = 'aws/credentials/aws_secret';

    /**
     * Log module directory path
     */
    const LOG_MODULE_PATH = 'aws/';

    /**
     * Get AWS version
     *
     * @return string
     */
    public function getAwsVersion()
    {
        $version = $this->getConfig()->getValue(self::XML_PATH_AWS_GENERAL_VERSION);
        return !$version ? self::AWS_VERSION : $version;
    }

    /**
     * Get AWS region
     *
     * @return string
     */
    public function getAwsRegion()
    {
        return $this->getConfig()->getValue(self::XML_PATH_AWS_GENERAL_REGION);
    }

    /**
     * Get AWS key
     *
     * @return string
     */
    public function getAwsKey()
    {
        return $this->getConfig()->getValue(self::XML_PATH_CREDENTIALS_AWS_KEY);
    }

    /**
     * Get AWS secret
     *
     * @return string
     */
    public function getAwsSecret()
    {
        return $this->getConfig()->getValue(self::XML_PATH_CREDENTIALS_AWS_SECRET);
    }

    /**
     * Get AWS client config
     *
     * @return array
     */
    public function getAwsClientConfig()
    {
        $config = [
            'version' => $this->getAwsVersion(),
            'region'  => $this->getAwsRegion(),
            'credentials' => [
                'key'     => $this->getAwsKey(),
                'secret'  => $this->getAwsSecret()
            ]
        ];

        return $config;
    }

    /**
     * Check whether an object is Guzzle service resource model
     *
     * @param mixed $object
     * @return bool
     */
    public function isAwsGuzzleResourceModel($object)
    {
        return gettype($object) == 'object'
            && $object instanceof \Guzzle\Service\Resource\Model;
    }

    /**
     * Get AWS client result
     *
     * @param mixed $result
     * @param string $param
     * @return string
     */
    public function getAwsClientResult($result, $param)
    {
        return $this->isAwsGuzzleResourceModel($result)
            ? $result->get($param) : '';
    }
}
