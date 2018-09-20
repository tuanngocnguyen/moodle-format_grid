<?php
/**
 * Created by PhpStorm.
 * User: nathannguyen
 * Date: 20/09/18
 * Time: 3:45 PM
 */

defined('MOODLE_INTERNAL') || die();

$observers = array(

    array(
        'eventname' => '\core\event\user_loggedin',
        'callback' => '\theme_bootstrap\login::user_loggedin',
    ),
    array(
        'eventname' => '\core\event\user_login_failed',
        'callback' => '\theme_bootstrap\login::user_loggedin',
    ),
);