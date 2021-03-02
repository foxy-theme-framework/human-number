<?php
namespace Ramphor\FriendlyNumbers\Abstracts;

use Ramphor\FriendlyNumbers\Interfaces\ScaleInterface;

abstract class Scale implements ScaleInterface
{
    protected $decimals = 2;
    protected $unit = '';

    protected $decimal_separator   = ',';
    protected $thousands_separator = '.';

    protected $jump  = 1000;
    protected $units = array();
    protected $steps = array();

    public function __construct($init = array())
    {
        if (isset($init['unit'])) {
            $this->setUnit($init['unit']);
        }
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function sortSteps()
    {
        $sortedSteps = array();
        $steps       = array_keys($this->steps);
        asort($steps);

        foreach ($steps as $step) {
            $sortedSteps[$step] = $this->steps[$step];
        }

        $this->steps = $sortedSteps;
    }

    public function getSteps()
    {
        return $this->steps;
    }

    public function getDecimals()
    {
        return $this->decimals;
    }

    public function getDecimalSeparator()
    {
        return $this->decimal_separator;
    }

    public function getThousandsSeparator()
    {
        return $this->thousands_separator;
    }

    public static function create()
    {
    }
}
