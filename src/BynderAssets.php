<?php
/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * @link      https://www.loqus.nl
 * @copyright Copyright (c) 2024 Loqus
 */

namespace loqus\byndercraftcms;

use loqus\byndercraftcms\models\SettingsModel;
use loqus\byndercraftcms\assetbundles\BynderAssetOverviewBundle;
use loqus\byndercraftcms\assetbundles\BynderAssetEditBundle;
use loqus\byndercraftcms\variables\BynderAssetVariable;
use loqus\byndercraftcms\services\BynderAssetService;


use Craft;
use craft\base\Plugin;
use craft\base\Model;
use craft\elements\Asset;
use craft\elements\Element;
use craft\services\Assets as AssetsService;
use craft\events\RegisterComponentTypesEvent;
use craft\events\PluginEvent;
use craft\events\ElementEvent;
use craft\services\Plugins;
use craft\web\Request;
use craft\web\twig\variables\CraftVariable;
use craft\events\ModelEvent;
use craft\services\Elements;
use craft\web\twig\variables\Cp;
use yii\base\Event;


/**
 * Class BynderAssets
 *
 * @author    Loqus
 * @package   byndercraftcms
 * @since     1.0.0
 */

class BynderAssets extends Plugin
{
    // Static Properties
    // =========================================================================

    public static BynderAssets $plugin;

    // Public Properties
    // =========================================================================

    public bool $hasCpSettings = true;

    public bool $hasCpSection = false;

    // Public Methods
    // =========================================================================
    public function __construct($id, $parent = null, array $config = []) {

        parent::__construct($id, $parent, $config);
    }
    public static function config(): array
    {
        return [
            'components' => [
                'bynderAsset' => ['class' => BynderAssetService::class],
                'bynderAssetVariable' => ['class' => BynderAssetVariable::class],
            ],
        ];
    }
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT,
            static function(Event $event) {
                $variable = $event->sender;
                $variable->set('bynder', BynderAssetVariable::class);
            }
        );
        Craft::$app->elements->on(Elements::EVENT_BEFORE_SAVE_ELEMENT, function(ElementEvent $e) {
                if ($e->element instanceof Asset) { 
                    $data = \Craft::$app->request->post();
                    $datlocation = \Craft::$app->request->post('fields[datLocation]');
                    $oldalt = \Craft::$app->request->post('old-alt');

                    if($datlocation != ""){
                        $e->element = BynderAssets::$plugin->bynderAsset->save10percentAsset($e->element,$datlocation);
                    }elseif($datlocation == "" && $oldalt != "")
                    {
                        $e->element = BynderAssets::$plugin->bynderAsset->save100percentAsset($e->element,$oldalt);
                    }
                }
        });

        $request = Craft::$app->request;
        if ($request->isCpRequest) {
            if ($request->getSegment(0) == 'assets' || $request->getSegment(1) == 'assets') {
                if(null !== $request->getSegment(2) && $request->getSegment(2) == 'edit')
                {
                    Craft::$app->getView()->registerAssetBundle(BynderAssetEditBundle::class);
                }else{
                    Craft::$app->getView()->registerAssetBundle(BynderAssetOverviewBundle::class);
                }
            }
        }
        
        Craft::info(
            Craft::t(
                'bynder-craft-cms',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?SettingsModel
    {
        return new SettingsModel();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'bynder-craft-cms/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
    
}

