<?php

namespace Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\AssetVariationFileApiInterface;

class AssetVariationFile implements Uploadable
{
    /**
     * @var AssetVariationFileApiInterface
     */
    private $api;

    /**
     * @var string
     */
    private $mediaFilePath;

    public function __construct(AssetVariationFileApiInterface $api, string $mediaFilePath)
    {
        $this->api = $api;
        $this->mediaFilePath = $mediaFilePath;
    }

    public function upload(array $data): iterable
    {
        foreach ($data as $fileData) {

            // @todo: add trailing slash to mediaFilePath if missing
            $path = $this->mediaFilePath.$fileData['path'];
            $assetCode = $fileData['asset'];

            if (isset($fileData['locale'])) {
                $this->api->uploadForLocalizableAsset($path,  $assetCode, $fileData['channel'], $fileData['locale']);

                continue;
            }

            $this->api->uploadForNotLocalizableAsset($path, $assetCode, $fileData['channel']);
        }

        return [];
    }
}
