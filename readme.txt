GRID COURSE FORMAT
============================
Package tested in: moodle 2.2+

QUICK INSTALL
==============
Download zip package, extract the grid folder and upload this folder into course/format/.

ABOUT
=============
Developed by:
Information in: 

FILES
--------------

* grid/format.php

  Code that actually displays the course view page.

* grid/config.php

  Configuration file, mainly controlling default blocks for the format.

* grid/lang/en/format_grid.php
* grid/lang/ru/format_grid.php

  Language file containing language strings for grid format.

  Note that existing formats store their language strings in the main
  moodle.php, which you can also do, but this separate file is recommended
  for contributed formats.

  Of course you can have other folders as well as just English and Russian
  if you want to provide multiple languages.

* grid/db/install.xml

  Database table definitions.

* grid/db/upgrade.php

  Database upgrade instructions.

* grid/version.php

  Required for using database tables. The file provides information 
  about plugin version (update when tables change) and required Moodle version.

* grid/styles.css

  The file is included in the CSS that Moodle generates.

* grid/backup/moodle2/backup_format_grid_plugin.class.php
  grid/backup/moodle2/restore_format_grid_plugin.class.php

  Backup and restore run automatically when backing up the course.
  You can't back up the course format data independently.

Upgrading from M1.9.
====================
When upgrading from Moodle 1.9 the grid icon images are moved to a 'legacy' files area.  So they will not show up when you
view the course as the format can no longer find them.  Therefore AFTER upgrading to Moodle 2.2 but before proceeding any
further please run the script 'convert_legacy_image.php' as follows:

1. Ensure you have updated fully to Moodle 2.2.
2. Ensure you have updated properly to the Moodle 2.2 version of the Grid format by clicking on 'Notifications' if you had
   not replaced the folder before performing the Moodle 2.2 upgrade/
3. Change the url to have from the root of your Moodle installation: /course/format/grid/convert_legacy_image.php -
   i.e: http://www.mysite.com/moodle/course/format/grid/convert_legacy_image.php
   If you wish to get the full log output then append '?logverbose=1' to the end of the URL like so:
   http://www.mysite.com/moodle/course/format/grid/convert_legacy_image.php?logverbose=1
   But keep in mind that with lots of records in the 'files' table this can cause the script to fail.
4. Observe the output of the script which is also replicated in the PHP log file.
5. Go back to the grid format course and confirm that the images are there.  It is possible that some old legacy files remain from
   old images that were replaced.  At the present moment in time I have no way of detecting them (to be certain that they are
   from the Grid format) in code.
6. I'm not sure of the security vulnerabilities of the script on the server so after you have used it and are confident of the
   results then move it and 'gdlib_m25.php' from the '/course/format/grid/' folder to a safe non-served folder.