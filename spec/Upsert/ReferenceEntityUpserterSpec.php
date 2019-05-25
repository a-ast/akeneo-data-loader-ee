<?php

namespace spec\Aa\AkeneoEnterpriseDataLoader\Upsert;

use Aa\AkeneoDataLoader\Upsert\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReferenceEntityUpserterSpec extends ObjectBehavior
{
    function let(ReferenceEntityApiInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(Uploadable::class);
    }

    function it_upserts(ReferenceEntityApiInterface $api)
    {
        $data = ['code' => 'brand', 'a' => 1];

        $api->upsert('brand', $data)->shouldBeCalled();

        $this->upload($data);
    }
}
