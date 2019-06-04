<?php

namespace Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;

class ReferenceEntity implements ApiAdapterInterface, Uploadable
{
    /**
     * @var ReferenceEntityApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Upload a reference entity.
     *
     * Important: batch mode is not yet supported in Akeneo API.
     */
    public function upload(array $data): iterable
    {
        foreach ($data as $entity) {

            $referenceEntityCode = $entity['code'];
            $this->api->upsert($referenceEntityCode, $entity);
        }

        return [];
    }
}
