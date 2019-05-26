<?php

namespace spec\Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReferenceEntitySpec extends ObjectBehavior
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

        $this->upload([$data]);
    }
}
