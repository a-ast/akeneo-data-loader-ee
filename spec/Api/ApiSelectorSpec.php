<?php

namespace spec\Aa\AkeneoEnterpriseDataLoader\Api;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApi;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiSelectorSpec extends ObjectBehavior
{
    function let(AkeneoPimEnterpriseClientInterface $apiClient, Configuration $configuration, ReferenceEntityApi $api)
    {
        $apiClient->getReferenceEntityApi()->willReturn($api);
        $configuration->getUploadDir()->willReturn('uploadDir');
        $configuration->getUpsertBatchSize()->willReturn(10);

        $this->beConstructedWith($apiClient, $configuration);
    }

    function it_selects_api()
    {
        $this->select('reference-entity')->shouldHaveType(Uploadable::class);
    }
}
