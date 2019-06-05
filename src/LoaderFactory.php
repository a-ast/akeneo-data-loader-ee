<?php

namespace Aa\AkeneoEnterpriseDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Api\Registry;
use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Aa\AkeneoDataLoader\Loader;
use Aa\AkeneoDataLoader\LoaderFactory as BaseLoaderFactory;
use Aa\AkeneoDataLoader\LoaderInterface;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\AssetReferenceFile;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\AssetVariationFile;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\ReferenceEntity;
use Aa\AkeneoEnterpriseDataLoader\ApiAdapter\ReferenceEntityRecord;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientBuilder;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;

class LoaderFactory extends BaseLoaderFactory
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration = null)
    {
        parent::__construct($configuration);

        $this->configuration = $configuration ?? Configuration::create('');
    }

    public function createByCredentials(Credentials $apiCredentials): LoaderInterface
    {
        $client = $this->createApiClient($apiCredentials);

        $registry = $this->createRegistry($client);

        return new Loader($registry, $this->configuration);
    }

    private function createRegistry(AkeneoPimEnterpriseClientInterface $client): RegistryInterface
    {
        $registry = new Registry();

        $uploadDir = $this->configuration->getUploadDir();

        $registry
            ->register('asset',    new StandardAdapter($client->getAssetApi()))
            ->register('asset-reference-file', new AssetReferenceFile($client->getAssetReferenceFileApi(), $uploadDir))
            ->register('asset-variation-file', new AssetVariationFile($client->getAssetVariationFileApi(), $uploadDir))
            ->register('reference-entity',  new ReferenceEntity($client->getReferenceEntityApi()))
            ->register('reference-entity-record',  new ReferenceEntityRecord($client->getReferenceEntityRecordApi()));

        return $registry;
    }

    private function createApiClient(Credentials $apiCredentials): AkeneoPimEnterpriseClientInterface
    {
        $clientBuilder = new AkeneoPimEnterpriseClientBuilder($apiCredentials->getBaseUri());

        return $clientBuilder->buildAuthenticatedByPassword(
            $apiCredentials->getClientId(),
            $apiCredentials->getSecret(),
            $apiCredentials->getUsername(),
            $apiCredentials->getPassword()
        );
    }
}
