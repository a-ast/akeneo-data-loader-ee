<?php

namespace Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityRecordApiInterface;

class ReferenceEntityRecord implements ApiAdapterInterface, BatchUploadable
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
        $referenceEntity = $data[0]['reference_entity'];

        foreach ($data as &$record) {
            unset($record['reference_entity']);
        }

        $response = $this->api->upsertList($referenceEntity, $data);

        return $response;
    }

    public function getBatchGroup(): string
    {
        return 'reference_entity';
    }
}
