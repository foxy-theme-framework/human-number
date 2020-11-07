<?php
namespace Ramphor\FriendlyNumbers;

class Parser
{
    protected static $locate;
    protected $scale;
    protected $raw;
    protected $value;
    protected $prefix;
    protected $parsed = false;

    protected static $defaultScale;

    public function __construct($number = null, $scale = null, $locate = null)
    {
        $this->raw = $number;
    }

    public function __toString()
    {
    }

    public static function init($locale)
    {
    }

    public function _parse()
    {
        $levels = array(
            1000000 => 'triệu',
            1000000000 => 'tỷ'
        );
        $sortedLevels = array_keys($levels);
        asort($sortedLevels);

        foreach($sortedLevels as $level) {
            if ($this->parsed) {
                break;
            }
            $cal = $this->raw / $level;
            if ( $cal >= 1 ) {
                $this->value = $cal;
                $this->prefix = $levels[$level];
            } else {
                $this->parsed = true;
            }
        }
        if (!$this->parsed) {
            if ($this->value <= 0) {
                $this->value = $this->raw;
            }

            $this->parsed = true;
        }
    }

    public function toArray()
    {
        if (!$this->parsed) {
            $this->_parse();
        }

        return array(
            'value' => $this->value,
            'prefix' => $this->prefix
        );
    }

    public static function parse($number, $scale, $locale)
    {
        $p = new static($number, $scale, $locale);
        $p->_parse();
        return $p;
    }
}
