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

class BynderAssetEditBundle extends AssetBundle
{
    public function init()
    {
        parent::init();
        $settings = BynderAssets::$plugin->getSettings();
        $portalurl = App::parseEnv($settings->portalurl);
        $language = $settings->language;
        $webroot = Craft::getAlias('@webroot');

        $jsonVars = [
            'portalurl' => $portalurl,
            'selecttype' => 'SingleSelect',
            'language' => $language,
            'volume' => 0,
            'templocation' => $webroot.'/storage/runtime/temp'
            ];
        $jsonVars = Json::encode($jsonVars);
        
        Craft::$app->getView()->registerJs("new Craft.CraftBynderAssetSelector(" . $jsonVars . ");");

        $this->sourcePath = "@loqus/bynderassets/assetbundles/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/bynder-compactview-3-latest.js',
            'js/bynderassetedit.js',
        ];

        $this->css = [
            'css/bynderasset.css',
        ];
    }
}
