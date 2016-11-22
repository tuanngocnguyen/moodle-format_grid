/**
 * Grid Format
 *
 * @package    course/format
 * @subpackage grid
 * @version    See the value of '$plugin->version' in version.php.
 * @copyright  2016 Gareth J Barnard
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @license    Chartist is MIT licenced: https://raw.githubusercontent.com/gionkunz/chartist-js/master/LICENSE-MIT
 */

/* jshint ignore:start */
define(['jquery', 'theme_bootstrapbase/bootstrap', 'core/log'], function($, bootstrap, log) {

    "use strict"; // jshint ;_;

    log.debug('Grid Format AMD');
    return {
        init: function() {
            $(document).ready(function($) {
                $("[data-toggle=tooltip]").tooltip();
            });
            log.debug('Grid Format AMD init');
        }
    }
});
/* jshint ignore:end */
