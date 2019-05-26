<?php

namespace spec\Aa\AkeneoEnterpriseDataLoader;

use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\LoaderInterface;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoaderFactorySpec extends ObjectBehavior
{
    function it_creates_from_api_client(AkeneoPimEnterpriseClientInterface $client)
    {
        $this->createByApiClient($client)->shouldHaveType(LoaderInterface::class);
    }

    function it_creates_from_credentials(Credentials $credentials)
    {
        $credentials->getBaseUri()->willReturn('uri');
        $credentials->getClientId()->willReturn('clientId');
        $credentials->getSecret()->willReturn('secret');
        $credentials->getUsername()->willReturn('user');
        $credentials->getPassword()->willReturn('pass');

        $this
            ->createByCredentials($credentials)
            ->shouldHaveType(LoaderInterface::class);
    }
}
