<?php
/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * @link      https://www.loqus.nl
 * @copyright Copyright (c) 2024 Loqus
 */

namespace loqus\byndercraftcms\services;

use Craft;
use craft\base\Component;
use craft\base\Element;
use craft\elements\Asset as AssetElement;
use craft\errors\AssetException;
use craft\helpers\FileHelper;
use craft\services\Assets;
use craft\services\Volumes as VolumeService;
use craft\queue\Queue;

use loqus\byndercraftcms\BynderAssets;
use loqus\byndercraftcms\elements\BynderAsset;

use yii\web\UploadedFile;

class BynderAssetService extends Component
{
    public function processAsset(mixed $data){
        $jsondecoded = json_decode($data);
        foreach ($jsondecoded as $k => $uploadedasset) {
            $title = $uploadedasset->title;
            $url = $uploadedasset->url;
            $originalextension = strtolower($uploadedasset->originalextension);
            $type = strtolower($uploadedasset->type);
            $databaseId = $uploadedasset->databaseId;
            $description = $uploadedasset->description;
            $volumehandle = $uploadedasset->volumehandle;
            $volume = $this->getVolume($volumehandle);
            $volumeId = $this->getVolumeId($volumehandle);
            $folderId = $uploadedasset->folder;
            $filenameparts = explode("/",$url);
            $filename = $filenameparts[count($filenameparts)-1];
            $fullfilename = $filename.".".strtolower($originalextension);
    
            $tempFilePath = sys_get_temp_dir().'/'.$fullfilename;
    
            file_put_contents($tempFilePath, file_get_contents($url));
            $originalsize = getimagesize($tempFilePath);
            $uploadedFile = new UploadedFile([
                'name' => basename($tempFilePath),
                'tempName' => $tempFilePath,
                'type' => FileHelper::getMimeType($tempFilePath),
                'size' => filesize($tempFilePath),
                'error' => UPLOAD_ERR_OK,
            ]);

            file_put_contents($tempFilePath, file_get_contents($url."?io=transform:fill,width:".$originalsize[0].",height:".$originalsize[1]."&quality=10"));
    
            $asset = new AssetElement();
    
            $asset->tempFilePath = $uploadedFile->tempName;
            $asset->filename = $uploadedFile->name;
            $asset->newFolderId = $folderId;
            $asset->volumeId = $volumeId;
            $asset->setFieldValues([
                'datLocation' => $url . "." . strtolower($originalextension),
                'mediaId' => $databaseId
            ]);
            $asset->setWidth($originalsize[0]);
            $asset->setHeight($originalsize[1]);
            Craft::$app->getElements()->saveElement($asset);
        }
    }

    public function save10percentAsset(AssetElement $asset,string $alt): AssetElement {
        $assetId = $asset->id;
        $fullfilename = basename($alt);
        
        $tempFilePath = sys_get_temp_dir().'/'.$fullfilename;
        file_put_contents($tempFilePath, file_get_contents($alt));
        $originalsize = getimagesize($tempFilePath);
        file_put_contents($tempFilePath, file_get_contents($alt."?io=transform:fill,width:".$originalsize[0].",height:".$originalsize[1]."&quality=10"));
        $uploadedFile = new UploadedFile([
            'name' => basename($tempFilePath),
            'tempName' => $tempFilePath,
            'type' => FileHelper::getMimeType($tempFilePath),
            'size' => filesize($tempFilePath),
            'error' => UPLOAD_ERR_OK,
        ]);
        $asset->tempFilePath = $tempFilePath;
        $asset->newFilename = $fullfilename;
        $asset->alt = $asset->title;
        return $asset;
    }
    public function save100percentAsset(AssetElement $asset,string $alt): AssetElement {
        $assetId = $asset->id;
        $fullfilename = basename($alt);
        
        $tempFilePath = sys_get_temp_dir().'/'.$fullfilename;
        file_put_contents($tempFilePath, file_get_contents($alt));
        $originalsize = getimagesize($tempFilePath);
        file_put_contents($tempFilePath, file_get_contents($alt."?io=transform:fill,width:".$originalsize[0].",height:".$originalsize[1]));
        $uploadedFile = new UploadedFile([
            'name' => basename($tempFilePath),
            'tempName' => $tempFilePath,
            'type' => FileHelper::getMimeType($tempFilePath),
            'size' => filesize($tempFilePath),
            'error' => UPLOAD_ERR_OK,
        ]);
        $asset->tempFilePath = $tempFilePath;
        $asset->newFilename = $fullfilename;
        $asset->alt = $asset->title;
        return $asset;
    }
    public function getVolumeId($handle) {
        $VolumeService = new VolumeService();
        $rawVolumes= $VolumeService->getAllVolumes();
        foreach($rawVolumes as $rawVol){
            if($handle == $rawVol->getFsHandle())
            {
                return $rawVol->id;
            }
            
        }
        return null;
    }
    public function getVolume($handle) {
        $VolumeService = new VolumeService();
        $rawVolumes= $VolumeService->getAllVolumes();
        foreach($rawVolumes as $rawVol){
            if($handle == $rawVol->getFsHandle())
            {
                return $rawVol;
            }
            
        }
        return null;
    }
}
