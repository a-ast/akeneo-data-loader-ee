<?php

namespace Aa\AkeneoEnterpriseDataLoader;

use Aa\AkeneoDataLoader\ApiSelector as BaseApiSelector;
use Aa\AkeneoDataLoader\Upsert\StandardUpserter;
use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Aa\AkeneoEnterpriseDataLoader\Upsert\AssetReferenceFileUpserter;
use Aa\AkeneoEnterpriseDataLoader\Upsert\AssetVariationFileUpserter;
use Aa\AkeneoEnterpriseDataLoader\Upsert\ReferenceEntityRecordUpserter;
use Aa\AkeneoEnterpriseDataLoader\Upsert\ReferenceEntityUpserter;
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

    public function select(string $apiAlias): Upsertable
    {
        switch ($apiAlias) {
            case 'asset':
                return new StandardUpserter($this->apiClient->getAssetApi());
            case 'asset-reference-file':
                return new AssetReferenceFileUpserter($this->apiClient->getAssetReferenceFileApi(), $this->mediaFilePath);
            case 'asset-variation-file':
                return new AssetVariationFileUpserter($this->apiClient->getAssetVariationFileApi(), $this->mediaFilePath);
            case 'reference-entity':
                return new ReferenceEntityUpserter($this->apiClient->getReferenceEntityApi());
            case 'reference-entity-record':
                return new ReferenceEntityRecordUpserter($this->apiClient->getReferenceEntityRecordApi());
            default:
                return parent::select($apiAlias);
        }

    }
}
