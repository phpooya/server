<?php
namespace phpooya\server\cron;

use phpooya\server\core\functions;

class PhpCron extends BaseCron
{
    public $filename;
    
    public function run()
    {
        if (parent::run()) {
            functions\serverInclude($this->filename);
        }
    }
}