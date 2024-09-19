<?php
/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * @link      https://www.loqus.nl
 * @copyright Copyright (c) 2024 Loqus
 */

namespace loqus\byndercraftcms\assetbundles;

use Craft;
use loqus\byndercraftcms\BynderAssets;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\helpers\Json;
use craft\helpers\App;

class BynderAssetOverviewBundle extends AssetBundle
{
    public function init()
    {
        $settings = BynderAssets::$plugin->getSettings();
        $portalurl = App::parseEnv($settings->portalurl);
        $language = $settings->language;
        $volume = Craft::$app->getRequest()->getQueryParams();
        if(isset($volume["source"]))
        {
            $webroot = Craft::getAlias('@webroot');

            $jsonVars = [
                'portalurl' => $portalurl,
                'selecttype' => "MultiSelect",
                'language' => $language,
                'volume' => $volume,
                'templocation' => $webroot.'/storage/runtime/temp'
                ];
            $jsonVars = Json::encode($jsonVars);
            
            Craft::$app->getView()->registerJs("new Craft.CraftBynderAssetSelector(" . $jsonVars . ");");

            $this->sourcePath = "@loqus/byndercraftcms/assetbundles/dist";

            $this->depends = [
                CpAsset::class,
            ];

            $this->js = [
                'js/bynder-compactview-3-latest.js',
                'js/bynderassetoverview.js',
            ];

            $this->css = [
                'css/bynderasset.css',
            ];
            
            parent::init();
        }else{
            if(Craft::$app->getRequest()->getFullPath() == "admin/assets"){
                Craft::$app->getView()->registerJs("new Craft.CraftBynderRefreshonload();");
                $this->sourcePath = "@loqus/byndercraftcms/assetbundles/dist";
                $this->depends = [
                    CpAsset::class,
                ];
                $this->js = [
                    'js/refresh.js',
                ];
                parent::init();
            }
        }
    }
}
