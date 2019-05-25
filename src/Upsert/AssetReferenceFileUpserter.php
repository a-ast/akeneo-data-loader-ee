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

    public function upsert(array $data): iterable
    {
        foreach ($data as $fileData) {

            // @todo: add trailing slash to mediaFilePath if missing
            $path = $this->mediaFilePath.$fileData['path'];
            $assetCode = $fileData['asset'];

            if (isset($fileData['locale'])) {
                $this->api->uploadForLocalizableAsset($path,  $assetCode, $fileData['locale']);

                continue;
            }

            $this->api->uploadForNotLocalizableAsset($path, $assetCode);
        }
    }
}
