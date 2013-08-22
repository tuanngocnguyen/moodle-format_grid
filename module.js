/**
 * Grid Information
 *
 * @package    course/format
 * @subpackage grid
 * @version    See the value of '$plugin->version' in version.php.
 * @copyright  &copy; 2012 G J Barnard in respect to modifications of standard topics format.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Dan Poltawski.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
 var selected_topic = null;

/**
 * @namespace
 */
M.format_grid = M.format_grid || {};

M.format_grid.hide_sections = function() {
    //Have to hide the div's using javascript so they are visible if javascript is disabled.
    var grid_sections = getElementsByClassName(document.getElementById("middle-column"), "li", "grid_section");
    for(var i = 0; i < grid_sections.length; i++) {
        grid_sections[i].style.display = 'none';
    }
    //Remove href link from icon anchors so they don't compete with javascript onlick calls
    var icon_links = getElementsByClassName(document.getElementById("iconContainer"), "a", "icon_link");
    for(var i = 0; i < icon_links.length; i++) {
        icon_links[i].href = "#";
    }
    document.getElementById("shadebox_close").style.display = "";

    initialize_shadebox();
    update_shadebox();
    window.onresize = function() {
        update_shadebox();
    }
}

function select_topic(evt, topic_no) {
    //Make the selected topic visible, scroll to it and hide all other topics.

    if(selected_topic != null) {
        document.getElementById('section-'+selected_topic).style.display = "none";
    }
    selected_topic = topic_no;

    document.getElementById("section-"+topic_no).style.display = "";
    //window.scroll(0,document.getElementById("section-"+topic_no).offsetTop);
    toggle_shadebox();
    return true;
}

function select_topic_edit(evt, topic_no) {
    //Scroll to the selected topic, don't hide anything.

    //Don't do anything if the edit link has been clicked.
    if((evt.srcElement||evt.target).parentNode.nodeName == "A") {
        return;
    }

    document.getElementById("section-"+topic_no).style.display = "";
    window.scroll(0,document.getElementById("section-"+topic_no).offsetTop);
}

/** Below is shadebox code **/

var shadebox_open = false;

function initialize_shadebox() {
    hide_shadebox();

    document.getElementById('shadebox_overlay').style.display="";
    document.body.appendChild(document.getElementById('shadebox'));

    var content = document.getElementById('shadebox_content');
    content.style.position = 'absolute';
    content.style.width = '90%';
    content.style.top = '50px';
    content.style.left = '5%';
    //content.style.marginLeft = '-400px';
    content.style.zIndex = '9000001';
}

function toggle_shadebox() {
    if(shadebox_open) {
        hide_shadebox();
        shadebox_open = false;
        window.scrollTo(0, 0);
    } else {
        show_shadebox();
        shadebox_open = true;
    }
}

function show_shadebox() {
    update_shadebox();
    document.getElementById("shadebox").style.display = "";
    update_shadebox();
}

function hide_shadebox() {

    document.getElementById("shadebox").style.display = "none";

}

//code from quirksmode.org
//author unknown.
function get_page_size() {

    var xScroll, yScroll;
    if(window.innerHeight && window.scrollMaxY) {
        xScroll = document.body.scrollWidth;
        yScroll = window.innerHeight + window.scrollMaxY;
    } else if(document.body.scrollHeight > document.body.offsetHeight) { //all but Explorer Mac
        xScroll = document.body.scrollWidth;
        yScroll = document.body.scrollHeight;
    } else { //Explorer Mac ... also works in Explorer 6 strict and safari
        xScroll = document.body.offsetWidth;
        yScroll = document.body.offsetHeight;
    }

    var windowWidth, windowHeight;
    if(self.innerHeight) { // all except Explorer
        windowWidth = self.innerWidth;
        windowHeight = self.innerHeight;
    } else if(document.documentElement && document.documentElement.clientHeight) { //Explorer 6 strict mode
        windowWidth = document.documentElement.clientWidth;
        windowHeight = document.documentElement.clientHeight;
    } else if(document.body) { //other Explorers
        windowWidth = document.body.clientWidth;
        windowHeight = document.body.clientHeight;
    }

    //for small pages with total height less than height of the viewport
    if(yScroll < windowHeight) {
        pageHeight = windowHeight;
    } else {
        pageHeight = yScroll;
    }

    //for small pages with total width less than width of the viewport
    if(xScroll < windowWidth) {
        pageWidth = windowWidth;
    } else {
        pageWidth = xScroll;
    }

    arrayPageSize = new Array(pageWidth, pageHeight, windowWidth, windowHeight);
    return arrayPageSize;
}

function update_shadebox() {
    //Make the overlay fullscreen (width happens automatically, so just update the height)
    var overlay = document.getElementById("shadebox_overlay");
    var pagesize = get_page_size();
    overlay.style.height = pagesize[1] + "px";
}
