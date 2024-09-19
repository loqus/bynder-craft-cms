/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * CraftBynderDam CSS
 *
 * @author    Bynder
 * @copyright Copyright (c) 2024 Loqus
 * @link      https://www.loqus.nl
 * @package   byndercraftcms
 * @since     1.0.0
 */


(function ($) {
    Craft.CraftBynderRefreshonload = Garnish.Base.extend(
    {
        init: function () {
            setTimeout(
                function() {
                    location.reload();
                }, 50
            );
        }
        });

})(jQuery);
