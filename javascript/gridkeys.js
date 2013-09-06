// We need to actually use the code manually here as 'gallery-event-nav-keys' has
// no init function to call from $PAGE->requires->yui_module();
YUI().use('moodle-format_grid-galleryeventnavkeys', function(Y) {
    Y.on('esc', function (e) {
        e.preventDefault();
        console.log("Esc pressed");
        console.log("Selected section no: " + M.format_grid.selected_section_no);
        M.format_grid.icon_toggle(e);
    });
    Y.on('left', function (e) {
        e.preventDefault();
        console.log("Left pressed");
        M.format_grid.arrow_left(e);
    });
    Y.on('right', function (e) {
        e.preventDefault();
        console.log("Right pressed");
        M.format_grid.arrow_right(e);
    });
    Y.on('enter', function (e) {
        e.preventDefault();
        console.log("Enter pressed");
        console.log("Selected section no: " + M.format_grid.selected_section_no);
        M.format_grid.icon_toggle(e);
    });
    Y.on('tab', function (e) {
        e.preventDefault();
        if (e.shiftKey) {
            console.log("Shift Tab pressed");
            M.format_grid.arrow_left(e);
        } else {
            console.log("Tab pressed");
            M.format_grid.arrow_right(e);
        }
    });
});
