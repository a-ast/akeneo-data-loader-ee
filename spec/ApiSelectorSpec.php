<?php

namespace spec\Aa\AkeneoEnterpriseDataLoader;

use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApi;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiSelectorSpec extends ObjectBehavior
{
    function let(AkeneoPimEnterpriseClientInterface $apiClient)
    {
        $this->beConstructedWith($apiClient);
    }

    function it_selects_api(AkeneoPimEnterpriseClientInterface $apiClient, ReferenceEntityApi $api)
    {
        $apiClient->getReferenceEntityApi()->willReturn($api);

        $this->select('reference-entities')->shouldHaveType(Upsertable::class);
    }
}
