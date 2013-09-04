// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Grid Format - A topics based format that uses a grid of user selectable images to popup a light box of the section.
 *
 * @package    course/format
 * @subpackage grid
 * @copyright  &copy; 2012 G J Barnard in respect to modifications of standard topics format.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Paul Krix and Julian Ridden.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 /**
 * @namespace
 */
M.format_grid = M.format_grid || {
    ourYUI: null,
    editing_on: null,
    update_capability: null,
    selected_section: null,
    num_sections: null,
    selected_section_no: -1,
    shadebox_shown_array: null
};
M.format_grid.shadebox = M.format_grid.shadebox || {};

M.format_grid.init = function(Y, the_editing_on, the_update_capability, the_num_sections, the_shadebox_shown_array) {
    "use strict";
    this.ourYUI = Y;
    this.editing_on = the_editing_on;
    this.update_capability = the_update_capability;
    this.selected_section = null;
    this.num_sections = parseInt(the_num_sections);
    console.log("SSA parameter: " + the_shadebox_shown_array);
    this.shadebox_shown_array = JSON.parse(the_shadebox_shown_array);
    console.log("SSA var: " + the_shadebox_shown_array);

    if (this.num_sections > 0) {
        this.selected_section_no = this.find_next_shown_section(this.num_sections, true);  // Section 0 can be in the grid.
    } else {
        this.selected_section_no = -1;
    }

    Y.delegate('click', this.icon_click, Y.config.doc, 'ul.gridicons a.gridicon_link', this);

    var shadeboxtoggleone = Y.one("#gridshadebox_overlay");
    if (shadeboxtoggleone) {
        shadeboxtoggleone.on('click', this.shadebox.toggle_shadebox, this.shadebox);
    }
    var shadeboxtoggletwo = Y.one("#gridshadebox_close");
    if (shadeboxtoggletwo) {
        shadeboxtoggletwo.on('click', this.shadebox.toggle_shadebox, this.shadebox);
    }

    // Have to show the column when editing / capability to update.
    if (the_editing_on && the_update_capability) {
        // Show the sections when editing.
        Y.all(".grid_section").removeClass('hide_section');
    } else {
        // Remove href link from icon anchors so they don't compete with javascript onlick calls.
        var icon_links = getElementsByClassName(document.getElementById("gridiconcontainer"), "a", "icon_link");
        for(var i = 0; i < icon_links.length; i++) {
            icon_links[i].href = "#";
        }
        document.getElementById("gridshadebox_close").style.display = "";

        M.format_grid.shadebox.initialize_shadebox();
        M.format_grid.shadebox.update_shadebox();
        window.onresize = function() {
            M.format_grid.shadebox.update_shadebox();
        }
    }
}

M.format_grid.icon_click = function(e) {
    "use strict";
    e.preventDefault();
    var icon_index = parseInt(e.currentTarget.get('id').replace("gridsection-", ""));
    //console.log(icon_index);
    this.selected_section_no = icon_index;
    this.icon_toggle(icon_index);
};

M.format_grid.icon_toggle = function() {
    "use strict";
    //console.log(this.selected_section_no);
    if (this.selected_section_no != -1) { // Then a valid shown section has been selected.
        if ((this.editing_on == true) && (this.update_capability == true)) {
            window.scroll(0,document.getElementById("section-" + this.selected_section_no).offsetTop);
        } else if (M.format_grid.shadebox.shadebox_open == true) {
            console.log("Shadebox was open");
            this.shadebox.toggle_shadebox();
        } else {
            console.log("Shadebox was closed");
            this.icon_change_shown();
            this.shadebox.toggle_shadebox();
        }
    } else {
        console.log("Grid format - no selected section to show.");
    }
};

M.format_grid.icon_change_shown = function() {
    "use strict";
    // Make the selected section visible, scroll to it and hide all other sections.
    if(this.selected_section != null) {
        this.selected_section.addClass('hide_section');
    }
    this.selected_section = this.ourYUI.one("#section-" + this.selected_section_no);

    this.selected_section.removeClass('hide_section');
};

/**
 * Returns the next shown section from the given starting point and direction.
 * If not found, returns -1.
 */
M.format_grid.find_next_shown_section = function(starting_point, increase_section) {
    var found = false;
    var current = starting_point;
    var next = -1;

    while(found == false) {
        if (increase_section == true) {
            current++;
            if (current > this.num_sections) {
                current = 0;
            }
        } else {
            current--;
            if (current < 0) {
                current = this.num_sections;
            }
        }

        // Guard against repeated looping code...
        if (current == starting_point) {
            found = true; // Exit loop and 'next' will be '-1'.
        } else if (this.shadebox_shown_array[current] == 2) { // This section can be shown.
            next = current;
            found = true; // Exit loop and 'next' will be 'current'.
        }
    }

    return next;
};

/** Below is key pressing code **/
M.format_grid.change_selected_section = function(increase_section) {
    this.selected_section_no = this.find_next_shown_section(this.selected_section_no, increase_section);
    console.log("Selected section no is now: " + this.selected_section_no);
    if (M.format_grid.shadebox.shadebox_open == true) {
        this.icon_change_shown();
    }
};


/** Below is shadebox code **/
M.format_grid.shadebox.shadebox_open;

M.format_grid.shadebox.initialize_shadebox = function() {
    "use strict";
    this.shadebox_open = false;
    this.hide_shadebox();

    document.getElementById('gridshadebox_overlay').style.display="";
    document.body.appendChild(document.getElementById('gridshadebox'));

    var content = document.getElementById('gridshadebox_content');
    content.style.position = 'absolute';
    content.style.width = '90%';
    content.style.top = '50px';
    content.style.left = '5%';
    //content.style.marginLeft = '-400px';
    content.style.zIndex = '9000001';
}

M.format_grid.shadebox.toggle_shadebox = function() {
    "use strict";
    if (this.shadebox_open) {
        this.hide_shadebox();
        this.shadebox_open = false;
    } else {
        window.scrollTo(0, 0);
        this.show_shadebox();
        this.shadebox_open = true;
    }
}

M.format_grid.shadebox.show_shadebox = function() {
    "use strict";
    this.update_shadebox();
    document.getElementById("gridshadebox").style.display = "";
    this.update_shadebox();
}

M.format_grid.shadebox.hide_shadebox = function() {
    "use strict";
    document.getElementById("gridshadebox").style.display = "none";
}

// Code from quirksmode.org.
// Author unknown.
M.format_grid.shadebox.get_page_size = function() {
    "use strict";
    var xScroll, yScroll;
    if(window.innerHeight && window.scrollMaxY) {
        xScroll = document.body.scrollWidth;
        yScroll = window.innerHeight + window.scrollMaxY;
    } else if(document.body.scrollHeight > document.body.offsetHeight) { // All but Explorer Mac.
        xScroll = document.body.scrollWidth;
        yScroll = document.body.scrollHeight;
    } else { // Explorer Mac ... also works in Explorer 6 strict and safari.
        xScroll = document.body.offsetWidth;
        yScroll = document.body.offsetHeight;
    }

    var windowWidth, windowHeight;
    if(self.innerHeight) { // All except Explorer.
        windowWidth = self.innerWidth;
        windowHeight = self.innerHeight;
    } else if(document.documentElement && document.documentElement.clientHeight) { // Explorer 6 strict mode.
        windowWidth = document.documentElement.clientWidth;
        windowHeight = document.documentElement.clientHeight;
    } else if(document.body) { //other Explorers
        windowWidth = document.body.clientWidth;
        windowHeight = document.body.clientHeight;
    }

    // For small pages with total height less than height of the viewport.
    var pageHeight;
    if(yScroll < windowHeight) {
        pageHeight = windowHeight;
    } else {
        pageHeight = yScroll;
    }

    // For small pages with total width less than width of the viewport.
    var pageWidth;
    if(xScroll < windowWidth) {
        pageWidth = windowWidth;
    } else {
        pageWidth = xScroll;
    }

    return new Array(pageWidth, pageHeight, windowWidth, windowHeight);
}

M.format_grid.shadebox.update_shadebox = function() {
    "use strict";
    // Make the overlay fullscreen (width happens automatically, so just update the height).
    var overlay = document.getElementById("gridshadebox_overlay");
    var pagesize = this.get_page_size();
    overlay.style.height = pagesize[1] + "px";
}