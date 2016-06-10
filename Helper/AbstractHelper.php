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
     * XML path AWS general partition
     */
    const XML_PATH_AWS_GENERAL_PARTITION = 'aws/general/partition';

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
     * AWS endpoints data file path
     */
    const AWS_ENDPOINTS_DATA_FILE_PATH = '/vendor/aws/aws-sdk-php/src/data/endpoints.json';

    /**
     * AWS default partition
     */
    const AWS_DEFAULT_PARTITION_CODE = 'aws';
    const AWS_DEFAULT_PARTITION_NAME = 'AWS Standard';

    /**
     * @var array
     */
    protected $awsDefaultPartition = [
        'code' => self::AWS_DEFAULT_PARTITION_CODE,
        'name' => self::AWS_DEFAULT_PARTITION_NAME
    ];

    /**
     * @var array
     */
    protected $awsEndpointsPartitions = [];

    /**
     * Get AWS version
     *
     * @return string
     */
    public function getAwsVersion()
    {
        $version = $this->getConfig()->getValue(static::XML_PATH_AWS_GENERAL_VERSION);
        return !$version ? static::AWS_VERSION : $version;
    }

    /**
     * Get AWS partition
     *
     * @return string
     */
    public function getAwsPartition()
    {
        return $this->getConfig()->getValue(static::XML_PATH_AWS_GENERAL_PARTITION);
    }

    /**
     * Get AWS region
     *
     * @return string
     */
    public function getAwsRegion()
    {
        return $this->getConfig()->getValue(static::XML_PATH_AWS_GENERAL_REGION);
    }

    /**
     * Get AWS key
     *
     * @return string
     */
    public function getAwsKey()
    {
        return $this->getConfig()->getValue(static::XML_PATH_CREDENTIALS_AWS_KEY);
    }

    /**
     * Get AWS secret
     *
     * @return string
     */
    public function getAwsSecret()
    {
        return $this->getConfig()->getValue(static::XML_PATH_CREDENTIALS_AWS_SECRET);
    }

    /**
     * Get AWS default partition
     *
     * @return array
     */
    public function getAwsDefaultPartition()
    {
        return $this->awsDefaultPartition;
    }

    /**
     * Get AWS endpoints data
     *
     * @return array
     */
    public function getAwsEndpointsData()
    {
        return \Aws\load_compiled_json(BP . self::AWS_ENDPOINTS_DATA_FILE_PATH);
    }

    /**
     * Get AWS endpoints partitions
     *
     * @return array
     */
    public function getAwsEndpointsPartitions()
    {
        if ($this->awsEndpointsPartitions) {
            return $this->awsEndpointsPartitions;
        }

        $endpointsData = $this->getAwsEndpointsData();
        foreach ($endpointsData['partitions'] as $partition) {
            $this->awsEndpointsPartitions[$partition['partition']] = $partition;
        }

        return $this->awsEndpointsPartitions;
    }

    /**
     * Get AWS partition regions
     *
     * @param string $partition
     * @return array
     */
    public function getAwsPartitionRegions($partition = self::AWS_DEFAULT_PARTITION_CODE)
    {
        $regions = [];
        $endpointsPartitions = $this->getAwsEndpointsPartitions();

        if (isset($endpointsPartitions[$partition])) {
            $regions = $endpointsPartitions[$partition]['regions'];
        }

        return $regions;
    }

    /**
     * Get AWS service endpoints
     *
     * @param string $partition
     * @param string $service
     * @return array
     */
    public function getAwsServiceEndpoints($partition, $service)
    {
        $endpoints = [];
        $endpointsPartitions = $this->getAwsEndpointsPartitions();

        if (isset($endpointsPartitions[$partition])) {
            $regions = $endpointsPartitions[$partition]['regions'];

            if (isset($endpointsPartitions[$partition]['services'][$service])) {
                $endpoints = $endpointsPartitions[$partition]['services'][$service]['endpoints'];
                foreach ($endpoints as $name => $value) {
                    $endpoints[$name]['description'] = $regions[$name]['description'];
                }
            }
        }

        return $endpoints;
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
     * Check whether an object is an AWS result
     *
     * @param mixed $object
     * @return bool
     */
    public function isAwsResult($object)
    {
        return gettype($object) == 'object' && $object instanceof \Aws\Result;
    }

    /**
     * Get AWS client result
     *
     * @param mixed $result
     * @param string $param
     * @return mixed
     */
    public function getAwsClientResult($result, $param)
    {
        return $this->isAwsResult($result) ? $result->get($param) : $result;
    }
}
