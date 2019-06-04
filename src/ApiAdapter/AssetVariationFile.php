<?php

namespace Aa\AkeneoEnterpriseDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\AssetVariationFileApiInterface;

class AssetVariationFile implements ApiAdapterInterface, Uploadable
{
    /**
     * @var AssetVariationFileApiInterface
     */
    private $api;

    /**
     * @var string
     */
    private $uploadDir;

    public function __construct(AssetVariationFileApiInterface $api, string $uploadDir)
    {
        $this->api = $api;
        $this->uploadDir = $uploadDir;
    }

    public function upload(array $data): iterable
    {
        foreach ($data as $fileData) {

            // @todo: add trailing slash to mediaFilePath if missing
            $path = $this->uploadDir.$fileData['path'];
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
