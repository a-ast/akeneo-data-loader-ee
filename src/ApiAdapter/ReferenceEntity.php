<?php

namespace Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;

class ReferenceEntity implements Uploadable
{
    /**
     * @var ReferenceEntityApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): iterable
    {
        foreach ($data as $entity) {

            $referenceEntityCode = $entity['code'];
            $this->api->upsert($referenceEntityCode, $entity);
        }

        return [];
    }
}
