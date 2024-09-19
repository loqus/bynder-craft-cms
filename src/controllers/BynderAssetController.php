<?php
/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * Bynder UCV Integration for CraftCMS
 *
 * @link      https://www.loqus.nl
 * @copyright Copyright (c) 2024 Loqus
 */

namespace loqus\byndercraftcms\controllers;

use Craft;
use craft\web\Controller;
use craft\controllers\AssetsController;
use loqus\byndercraftcms\BynderAssets;
use yii\web\Response;

class BynderAssetController extends AssetsController
{
    public function actionSaveBynderAsset(): Response
    {
        $this->requirePostRequest();
        $data = \Craft::$app->request->post('data');
        

        $asset = BynderAssets::$plugin->bynderAsset->processAsset($data);

        return $this->asJson([
            'success: '.$asset->id => true,
        ]);
    }
}
