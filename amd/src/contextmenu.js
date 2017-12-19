/**
 * Grid Format
 *
 * @package    course/format
 * @subpackage grid
 * @version    See the value of '$plugin->version' in version.php.
 * @copyright  2017 Gareth J Barnard
 * @author     G J Barnard - {@link http://about.me/gjbarnard} and
 *                           {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {
    log.debug('Grid Format Context Menu AMD');
    var menuShown = false;
    var currentSection = 0;
    var contextMenu = null;
    var sectionRedirect = null;

    $.fn.rightClickContextMenu = function() {
        $(this).find('li').each(function() {
            var us = $(this);
            us.contextmenu(function(e) {
                e.preventDefault();
                log.debug(us.html());
                log.debug(us.find('.gridicon_link').html());
                //var icon_index = parseInt(us.find('.gridicon_link').get('id').replace("gridsection-", ""));
                //var icon_index = parseInt(us.get('id').replace("gridsection-", ""));
                log.debug(us.attr('class'));
                log.debug(us.find('.gridicon_link').attr('id'));
                currentSection = parseInt(us.find('.gridicon_link').attr('id').replace("gridsection-", ""));
                log.debug('Grid Format Context Menu AMD rightClickContextMenu id ' + currentSection);
                log.debug('Grid Format Context Menu AMD rightClickContextMenu pageX ' + e.pageX + ' pageY ' + e.pageY);
                log.debug('Grid Format Context Menu AMD rightClickContextMenu clientX ' + e.clientX + ' clientY ' + e.clientY);

                contextMenu.css('top', e.clientY).css('left', e.clientX); // Using window co-ordinates.
                contextMenu.show();
                menuShown = true;
            });
        });
    };

    $.fn.notInMenu = function(pageX, pageY) {
        var usOffset = $(this).offset();
        //var windowLeft = $(window).scrollLeft();
        //var windowTop = $(window).scrollTop();
        //log.debug('contextMenu left ' + usOffset.left + ' top ' + usOffset.top + ' width ' + $(this).outerWidth() + ' height ' + $(this).outerHeight() + ' winLeft ' + windowLeft + ' winTop ' + windowTop);

        var usRight = usOffset.left + $(this).outerWidth();
        var usBottom = usOffset.top + $(this).outerHeight();
        log.debug('contextMenu pageX ' + pageX + ' pageY ' + pageY);
        log.debug('contextMenu left ' + usOffset.left + ' top ' + usOffset.top + ' width ' + $(this).outerWidth() + ' height ' + $(this).outerHeight() + ' usRight ' + usRight + ' usBottom ' + usBottom);

        if ((pageX >= usOffset.left) && (pageX <= usRight) &&
            (pageY >= usOffset.top) && (pageY <= usBottom)) {
            return false;
        } else {
            return true;
        }
    };

    return {
        init: function(data) {
            $(document).ready(function($) {
                sectionRedirect = data.sectionredirect;
                contextMenu = $('#gridcontextmenu');
                $('#gridnewpage').click(function() {
                    window.open(sectionRedirect + "&section=" + currentSection);
                });
                $('#gridiconcontainer .gridicons').rightClickContextMenu();
                $('body').mousedown(function(e) {
                    if (menuShown) {
                        if (contextMenu.notInMenu(e.pageX, e.pageY)) { // Using page co-ordinates to compare with document offset.
                            contextMenu.hide();
                            menuShown = false;
                        }
                    }
                });
                $(window).scroll(function() {
                    if (menuShown) {
                        contextMenu.hide();
                        menuShown = false;
                    }
                });
            });
            log.debug('Grid Format Context Menu AMD init');
        }
    }
});
/* jshint ignore:end */
