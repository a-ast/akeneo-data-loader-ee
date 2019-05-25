<?php

namespace Aa\AkeneoEnterpriseDataLoader\Upsert;

use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityRecordApiInterface;

class ReferenceEntityRecordUpserter implements Upsertable
{
    /**
     * @var ReferenceEntityRecordApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityRecordApiInterface $api)
    {
        $this->api = $api;
    }

    public function upsert(array $data): iterable
    {
        $responses = [];

        foreach ($data as $referenceEntityCode => $records) {
            $response = $this->api->upsertList($referenceEntityCode, $records);

            $responses = array_merge($responses, $response);
        }

        return $responses;
    }
}
