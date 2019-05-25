<?php

namespace Aa\AkeneoEnterpriseDataLoader\Upsert;

use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;

class ReferenceEntityUpserter implements Upsertable
{
    /**
     * @var ReferenceEntityApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityApiInterface $api)
    {
        $this->api = $api;
    }

    public function upsert(array $data): iterable
    {
        foreach ($data as $referenceEntityCode => $entities) {

            $this->api->upsert($referenceEntityCode, $entities);
        }

        return [];
    }
}
