Grid Course Format
============================
Package tested in: Moodle version 2012062504.01 release 2.3.4+ (Build: 20130118)

Requires Moodle version 2012062504.01 release 2.3.4+ (Build: 20130118) because of MDL-36095.

BETA DEVELOPMENT VERSION - NOT FOR PRODUCTION SITES - Please place comments / feedback on:
http://tracker.moodle.org/browse/CONTRIB-3769 - preferred.
or
http://moodle.org/mod/forum/discuss.php?d=207059

QUICK INSTALL
==============
Download zip package, extract the grid folder and upload this folder into course/format/.

NOTE: If you have previously installed a development version and get the latest code you MUST:
Remove the row with the 'plugin' of 'format_grid' in the 'config_plugins' table and drop the 'format_grid_icon'
and 'format_grid_summary' tables in the database before clicking on 'notifications'.

If upgrade fails, please perform the actions as detailed in the note above.

MyMobile alterations
====================

If you are using the MyMobile theme you need to change the files 'layout/general.php' and 'layout/embedded.php' in
the theme as follows:

At the bottom of 'general.php':

        </div>
    </div><!-- ends page -->

    <!-- empty divs with info for the JS to use -->
    <div id="<?php echo sesskey(); ?>" class="mobilesession"></div>
    <div id="<?php p($CFG->wwwroot); ?>" class="mobilesiteurl"></div>
    <div id="<?php echo $dtheme;?>" class="datatheme"></div>
    <div id="<?php echo $dthemeb;?>" class="datathemeb"></div>
    <div id="page-footer"><!-- empty page footer needed by moodle yui for embeds --></div>
    <!-- end js divs -->

    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>

to:

        </div>

        <!-- empty divs with info for the JS to use -->
        <div id="<?php echo sesskey(); ?>" class="mobilesession"></div>
        <div id="<?php p($CFG->wwwroot); ?>" class="mobilesiteurl"></div>
        <div id="<?php echo $dtheme;?>" class="datatheme"></div>
        <div id="<?php echo $dthemeb;?>" class="datathemeb"></div>
        <div id="page-footer"><!-- empty page footer needed by moodle yui for embeds --></div>
        <!-- end js divs -->

    <?php echo $OUTPUT->standard_end_of_body_html() ?>
    </div><!-- ends page -->
</body>

In 'embedded.php':

    <?php if ($mypagetype == 'mod-chat-gui_ajax-index') { ?>
    <div data-role="page" id="chatpage" data-fullscreen="true" data-title="<?php p($SITE->shortname) ?>">
        <?php echo $OUTPUT->main_content(); ?>
        <input type="button" value="back" data-role="none" id="chatback" onClick="history.back()">
    </div>
    <?php } else { ?>
    <div id="content2" data-role="page" data-title="<?php p($SITE->shortname) ?>" data-theme="<?php echo $datatheme;?>">
        <div data-role="header" data-theme="<?php echo $datatheme;?>">
            <h1><?php echo $PAGE->heading ?>&nbsp;</h1>
            <?php if ($mypagetype != "help") { ?>
                <a class="ui-btn-right" data-ajax="false" data-icon="home" href="<?php p($CFG->wwwroot) ?>" data-iconpos="notext"><?php p(get_string('home')); ?></a>
            <?php } ?>
        </div>
        <div data-role="content" class="mymobilecontent" data-theme="<?php echo $databodytheme;?>">
            <?php echo $OUTPUT->main_content(); ?>
        </div>
    </div>
    <?php } ?>
    <!-- START OF FOOTER -->
    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>

to:

    <?php if ($mypagetype == 'mod-chat-gui_ajax-index') { ?>
    <div data-role="page" id="chatpage" data-fullscreen="true" data-title="<?php p($SITE->shortname) ?>">
        <?php echo $OUTPUT->main_content(); ?>
        <input type="button" value="back" data-role="none" id="chatback" onClick="history.back()">
    <?php } else { ?>
    <div id="content2" data-role="page" data-title="<?php p($SITE->shortname) ?>" data-theme="<?php echo $datatheme;?>">
        <div data-role="header" data-theme="<?php echo $datatheme;?>">
            <h1><?php echo $PAGE->heading ?>&nbsp;</h1>
            <?php if ($mypagetype != "help") { ?>
                <a class="ui-btn-right" data-ajax="false" data-icon="home" href="<?php p($CFG->wwwroot) ?>" data-iconpos="notext"><?php p(get_string('home')); ?></a>
            <?php } ?>
        </div>
        <div data-role="content" class="mymobilecontent" data-theme="<?php echo $databodytheme;?>">
            <?php echo $OUTPUT->main_content(); ?>
        </div>
        <?php } ?>
        <!-- START OF FOOTER -->
        <?php echo $OUTPUT->standard_end_of_body_html() ?>
    </div>
</body>


About
=============
Developed by:
Information in: 

Files
--------------

* grid/format.php

  Code that actually displays the course view page.

* grid/config.php

  Configuration file, mainly controlling default blocks for the format.

* grid/lang/en/format_grid.php
* grid/lang/ru/format_grid.php
* grid/lang/es/format_grid.php
* grid/lang/fr/format_grid.php

  Language file containing language strings for grid format.

  Note that existing formats store their language strings in the main
  moodle.php, which you can also do, but this separate file is recommended
  for contributed formats.

  Of course you can have other folders as well as just English and Russian
  if you want to provide multiple languages.

* grid/db/install.xml

  Database table definitions.

* grid/db/upgrade.php

  Database upgrade script.

* grid/version.php

  Required for using database tables. The file provides information 
  about plugin version (update when tables change) and required Moodle version.

* grid/styles.css

  The file include in the CSS Moodle generates.

* grid/backup/moodle2/backup_format_grid_plugin.class.php
  grid/backup/moodle2/restore_format_grid_plugin.class.php

  Backup and restore run automatically when backing up the course.
  You can't back up the course format data independently.

Roadmap
=============

1. Improved instructions.
2. User definable grid row icon numbers - https://moodle.org/mod/forum/discuss.php?d=196716

History
=============

13th July 2012 - Version 2.3
Change by G J Barnard
1. First release for Moodle 2.3

22nd August 2012 - Version 2.3.1
Change by G J Barnard
1. Added missing 'current section' string.

19th December 2012 - Version 2.3.2
Change by G J Barnard
1. Fixed ability to use png files because of attempting to use jpeg quality setting.
2. Increased quality setting for better icons.

21st December 2012 - Version 2.3.2.1
Change by G J Barnard
1. Fixed BOM (http://docs.moodle.org/23/en/UTF-8_and_BOM) issue in 'lib.php' and 'lang/ru/format_grid.php' which can cause the icons not to display.

12th January 2013 - Version 2.3.2.2
Change by G J Barnard
1. Fixed inadvertent application of 2.4 code.
2. Fixed issue in editimage.php where the GD library needs to be used for image conversion for transparent PNG's.
3. Perform a 'Purge all caches' under 'Home -> Site administration -> Development -> Purge all caches' after this is installed.

21st January 2013 - Version 2.3.2.3 - Beta version, not for production servers.
Change by G J Barnard
1. Changes to 'renderer.php' because of MDL-36095 hence requiring Moodle version 2012062504.01 release 2.3.4+ (Build: 20130118) and above.

19th February 2013 - Version 2.3.2.3 - Beta version, not for production servers.
Change by G J Barnard
1. Changes to 'format.php' and 'renderer.php' to use renamed 'lib.php' -> 'module.js' to use the page requirements manager
   such that interaction with the MyMobile theme is reliable when 'MyMobile alterations' above implemented.

Authors
-------
J Ridden - Moodle profile: https://moodle.org/user/profile.php?id=39680 - Web: http://www.moodleman.net
G J Barnard - Moodle profile: moodle.org/user/profile.php?id=442195 - Web profile: about.me/gjbarnard