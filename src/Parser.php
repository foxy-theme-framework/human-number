<?php
namespace Ramphor\FriendlyNumbers;

class Parser
{
    protected static $locate;
    protected $scale;
    protected $raw;
    protected $value;
    protected $unit;

    protected static $defaultScale;

    public function __construct($number = null, $scale = null, $locate = null)
    {
        $this->raw = $number;
        if (is_null(static::$defaultScale)) {
            static::$defaultScale = static::createDefaultScale();
        }
    }

    public static function createDefaultScale() {
    }

    public function __toString()
    {
    }

    public static function init($locale)
    {
    }

    public function _parse($number, $scale, $locale)
    {
    }

    public function toArray()
    {
        return array(
        );
    }

    public static function parse($number, $scale, $locale) {
        $p = new static($number, $scale, $locale);
        $p->_parse();
        return $p;
    }

    public static function parseString($number, $decimals = 3) {
        $strlen = strlen($number);

        if ($strlen < 4) {
            return $number . ' ';
        } else if ($strlen < 7) {
            return round($number / 1000, $decimals) . ' ngìn ';
        } else if ($strlen < 10) {
            return round($number / 1000000, $decimals) . ' triệu ';
        } else if ($strlen < 13) {
            return round($number / 1000000000, $decimals) . ' tỷ ';
        }

        return ' ';
    }
}
