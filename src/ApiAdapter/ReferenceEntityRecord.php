<?php

namespace Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
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

    public function upload(iterable $data): iterable
    {
        $batchGenerator = new ChannelingBatchGenerator(100, 'reference_entity');

        foreach ($batchGenerator->getBatches($data) as $records) {

            $referenceEntity = $records[0]['reference_entity'];

            foreach ($records as &$record) {
                unset($record['reference_entity']);
            }

            $response = $this->api->upsertList($referenceEntity, $records);

            yield from $response;
        }
    }
}
