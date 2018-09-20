<?php
/**
 * Created by PhpStorm.
 * User: nathannguyen
 * Date: 19/09/18
 * Time: 4:55 PM
 */


namespace theme_bootstrap;
require_once($CFG->dirroot . '/local/ltu_domains/lib.php');

class login extends \core_auth\output\login
{

    public $copyright;
    public $importantnotice;
    public $domains;


    public function __construct(\core_auth\output\login $parentobject)
    {
        $values = get_object_vars($parentobject);
        foreach($values AS $key=>$value)
        {
            $this->$key = $value;
        }
        // Domains.
        $this->domains = [];
        $ltudomains = local_ltu_domains_generate_domains();
        foreach($ltudomains as $domain => $name) {
            $selected = isset($_COOKIE['ltu_domain']) && $_COOKIE['ltu_domain'] == $domain ? 'selected' : '';
            array_push($this->domains, array('domain' => $domain,
                "name" => $name,
                "selected"  => $selected
            ));
        }
        //
        $theme = \theme_config::load('bootstrap');
        // Copyright.
        $this->copyright = $theme->settings->copyright;
        // Important Notice.
        $this->importantnotice = $theme->settings->importantnotice;
    }

    public function export_for_template(\renderer_base $output) {
        $data = parent::export_for_template($output);
        $data->hascopyright = !empty($this->copyright);
        $data->hasimportantnotice = !empty($this->importantnotice);
        $data->hasdomains = !empty($this->domains);
        $data->copyright = $this->copyright;
        $data->importantnotice = $this->importantnotice;
        $data->domains = $this->domains;
        return $data;
    }

    public static function user_loggedin($event) {
//        $data = (object)$event;
//        if (isset($_POST['domain'])) {
//            setcookie("ltu_domain", clean_param($_POST['domain'], PARAM_TEXT), time()+(60*60*24*365));
//            // We may redisplay the page and that will require the cookie set to display the correct name.
//            $_COOKIE['ltu_domain'] = clean_param($_POST['domain'], PARAM_TEXT);
//        }
    }
}