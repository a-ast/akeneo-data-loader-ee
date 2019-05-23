<?php

namespace Aa\AkeneoEnterpriseDataLoader;

use Aa\AkeneoDataLoader\ApiSelector as BaseApiSelector;
use Aa\AkeneoDataLoader\Upsert\StandardUpserter;
use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Aa\AkeneoEnterpriseDataLoader\Upsert\ReferenceEntityUpserter;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;

class ApiSelector extends BaseApiSelector 
{
    /**
     * @var AkeneoPimEnterpriseClientInterface
     */
    private $apiClient;
    
    public function __construct(AkeneoPimEnterpriseClientInterface $apiClient)
    {
        parent::__construct($apiClient);
        
        $this->apiClient = $apiClient;
    }

    public function select(string $apiAlias): Upsertable
    {
        switch ($apiAlias) {
            case 'reference-entities':
                return new ReferenceEntityUpserter($this->apiClient->getReferenceEntityApi());
            default:
                return parent::select($apiAlias);
        }

    }
}
