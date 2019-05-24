<?php

namespace Aa\AkeneoEnterpriseDataLoader\Upsert;

use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\PimEnterprise\ApiClient\Api\AssetReferenceFileApiInterface;

class AssetReferenceFileUpserter implements Upsertable
{
    /**
     * @var AssetReferenceFileApiInterface
     */
    private $api;

    /**
     * @var string
     */
    private $mediaFilePath;

    public function __construct(AssetReferenceFileApiInterface $api, string $mediaFilePath)
    {
        $this->api = $api;
        $this->mediaFilePath = $mediaFilePath;
    }

    public function upsert(array $data)
    {
        // @todo: add trailing slash to mediaFilePath if missing
        $path = $this->mediaFilePath.$data['path'];

        if (isset($data['locale'])) {
            $this->api->uploadForLocalizableAsset($path, $data['asset'], $data['locale']);

            return;
        }

        $this->api->uploadForNotLocalizableAsset($path, $data['asset']);
    }
}
