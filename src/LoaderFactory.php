<?php

namespace Aa\AkeneoEnterpriseDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Loader;
use Aa\AkeneoDataLoader\LoaderInterface;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use Aa\AkeneoEnterpriseDataLoader\Api\ApiSelector;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientBuilder;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;

class LoaderFactory
{
    public function createByApiClient(AkeneoPimEnterpriseClientInterface $client, Configuration $configuration = null): LoaderInterface
    {
        if (null === $configuration) {
            $configuration = Configuration::create('');
        }

        $apiSelector = new ApiSelector($client, $configuration);
        $responseValidator = new ResponseValidator();

        return new Loader($apiSelector, $responseValidator);
    }

    public function createByCredentials(Credentials $apiCredentials, Configuration $configuration = null): LoaderInterface
    {
        $clientBuilder = new AkeneoPimEnterpriseClientBuilder($apiCredentials->getBaseUri());

        $client = $clientBuilder->buildAuthenticatedByPassword(
            $apiCredentials->getClientId(),
            $apiCredentials->getSecret(),
            $apiCredentials->getUsername(),
            $apiCredentials->getPassword()
        );

        return $this->createByApiClient($client, $configuration);
    }
}
