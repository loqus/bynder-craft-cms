<?php
/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * @link      https://www.loqus.nl
 * @copyright Copyright (c) 2024 Loqus
 */

namespace loqus\byndercraftcms\models;


use Craft;
use craft\base\Model;


class SettingsModel extends Model
{
    // Public Properties
    // =========================================================================
    public string $portalurl = '';
    public string $language = 'en_US';
    
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['portalurl','language'], 'string'],
            [['portalurl','language'], 'required'],
        ];
    }
}
