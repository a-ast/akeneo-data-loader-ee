<?php

namespace Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityRecordApiInterface;

class ReferenceEntityRecord implements Uploadable
{
    /**
     * @var ReferenceEntityRecordApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityRecordApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): iterable
    {
        $responses = [];

        foreach ($data as $referenceEntityCode => $records) {
            $response = $this->api->upsertList($referenceEntityCode, $records);

            $responses = array_merge($responses, $response);
        }

        return $responses;
    }
}
