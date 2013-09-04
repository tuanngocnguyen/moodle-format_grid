// We need to actually use the code manually here as 'gallery-event-nav-keys' has
// no init function to call from $PAGE->requires->yui_module();
YUI().use('moodle-format_grid-galleryeventnavkeys', function(Y) {
    Y.on('esc', function (e) {
        console.log("Esc pressed");
        console.log("Selected section no: " + M.format_grid.selected_section_no);
        M.format_grid.icon_toggle();
    });
    Y.on('left', function (e) {
        console.log("Left pressed");
        M.format_grid.change_selected_section(false);
    });
    Y.on('right', function (e) {
        console.log("Right pressed");
        M.format_grid.change_selected_section(true);
    });
});
