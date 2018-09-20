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
            array_push($this->domains, array('domain' => $domain, "name" => $name));
        }

        // TODO: Get Copyright content from settings/Configuration
        $this->copyright = "<div class=\"statement-div\">
                                    <p>Commonwealth of Australia</p>
                                    <p><i>Copyright Act 1968</i></p>
                                    <h3>Warning<br/></h3>
                                    <p>This material has been reproduced and communicated to you by or on behalf of La Trobe University under Section 113P of the <i>Copyright Act 1968</i> (the <i><b>Act</b></i>).</p>
                                    <p>The material in this communication may be subject to copyright<br>
                                    under the Act. Any further copying or communication of this material<br>
                                    by you may be the subject of copyright protection under the Act.</p>
                                    <p>Do not remove this notice.</p>
                                    </div>
                                ";
        // TODO: Get Important Notice content from settings/Configuration
        $this->importantnotice = "Academic Integrity
            At La Trobe, academic integrity is taken very seriously. 
            The University is responsible for awarding credit for honestly conducted work. 
            You also have responsibilities and understanding these will help you to succeed in your studies.";
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
}