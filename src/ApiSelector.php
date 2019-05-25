<?php

namespace Aa\AkeneoEnterpriseDataLoader;

use Aa\AkeneoDataLoader\ApiSelector as BaseApiSelector;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
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
    private $apiClient;

    /**
     * @var string
     */
    private $mediaFilePath;

    public function __construct(AkeneoPimEnterpriseClientInterface $apiClient, string $mediaFilePath)
    {
        parent::__construct($apiClient);
        
        $this->apiClient = $apiClient;
        $this->mediaFilePath = $mediaFilePath;
    }

    public function select(string $apiAlias): Uploadable
    {
        switch ($apiAlias) {
            case 'asset':
                return new StandardAdapter($this->apiClient->getAssetApi());
            case 'asset-reference-file':
                return new AssetReferenceFile($this->apiClient->getAssetReferenceFileApi(), $this->mediaFilePath);
            case 'asset-variation-file':
                return new AssetVariationFile($this->apiClient->getAssetVariationFileApi(), $this->mediaFilePath);
            case 'reference-entity':
                return new ReferenceEntity($this->apiClient->getReferenceEntityApi());
            case 'reference-entity-record':
                return new ReferenceEntityRecord($this->apiClient->getReferenceEntityRecordApi());
            default:
                return parent::select($apiAlias);
        }

    }
}
