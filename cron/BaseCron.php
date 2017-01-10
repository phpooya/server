<?php
namespace phpooya\server\cron;

use phpooya\server\core\Object;

class BaseCron extends Object
{
    /**
     * Period structure:
     * <minute:0-59> <hour:0-23> <day of month:1-31> <month of year:1-12> <day of week:1-7 1=monday> <year:1900-3000>
     */
    public $period = "* * * * * *";
    
    public function run()
    {
        if ($parts = $this->getParsedPeriod()) {
            if ($this->matchPart($parts[0], date('i')) and
                $this->matchPart($parts[1], date('H')) and
                $this->matchPart($parts[2], date('d')) and
                $this->matchPart($parts[3], date('m')) and
                $this->matchPart($parts[4], date('N')) and
                $this->matchPart($parts[5], date('Y'))) {
                    return true;
            }
        }
        return false;
    }

    private function matchPart($part, $timePart)
    {
        if(preg_match_all('/(?:(\*\/\d+)|(\d+\-\d+)|(\d+)|(\*))/', $part, $matches)) {
            foreach ($matches[0] as $match) {
                if (empty($match)) {
                    continue;
                } elseif ($match == '*' or is_numeric($match) and $match == $timePart) {
                    return true;
                } elseif ($subPart = explode('-', $match) and count($subPart) == 2 and $timePart >= $subPart[0] and $timePart <= $subPart[1]) {
                    return true;
                } elseif (false) { /** TODO: check star-slash lines. */
                    return true;
                }
            }
        }
        return false;
    }

    private function getParsedPeriod()
    {
        $parts = explode(" ", preg_replace('/\s+/', ' ', $this->period));
        if(count($parts) != 6) {
            return false;
        }
        return $parts;
    }
}