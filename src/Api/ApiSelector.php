<?php

namespace Aa\AkeneoEnterpriseDataLoader\Api;

use Aa\AkeneoDataLoader\Api\ApiSelector as BaseApiSelector;
use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\AssetReferenceFile;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\AssetVariationFile;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\ReferenceEntityRecord;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\ReferenceEntity;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;

class ApiSelector extends BaseApiSelector 
{
    /**
     * @var AkeneoPimEnterpriseClientInterface
     */
    protected $apiClient;

    public function __construct(AkeneoPimEnterpriseClientInterface $apiClient, Configuration $configuration)
    {
        parent::__construct($apiClient, $configuration);
        
        $this->apiClient = $apiClient;
    }

    public function select(string $apiAlias): ApiAdapterInterface
    {
        $uploadDir = $this->configuration->getUploadDir();

        switch ($apiAlias) {
            case 'asset':
                return new StandardAdapter($this->apiClient->getAssetApi());

            case 'asset-reference-file':
                return new AssetReferenceFile($this->apiClient->getAssetReferenceFileApi(), $uploadDir);

            case 'asset-variation-file':
                return new AssetVariationFile($this->apiClient->getAssetVariationFileApi(), $uploadDir);

            case 'reference-entity':
                return new ReferenceEntity($this->apiClient->getReferenceEntityApi());

            case 'reference-entity-record':
                return new ReferenceEntityRecord($this->apiClient->getReferenceEntityRecordApi());

            default:
                return parent::select($apiAlias);
        }

    }
}
