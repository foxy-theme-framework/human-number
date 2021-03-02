<?php
namespace Ramphor\FriendlyNumbers\Abstracts;

use Ramphor\FriendlyNumbers\Interfaces\ScaleInterface;

abstract class Scale implements ScaleInterface
{
    protected $decimals = 2;
    protected $unit = '';
    protected $pluralFormat = '%ss';
    protected $displayFullUnitName = false;

    protected $decimal_separator   = ',';
    protected $thousands_separator = '.';

    protected $jump  = 1000;
    protected $units = array();
    protected $steps = null;

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
        if (is_null($this->steps)) {
            $steps         = array();
            $units         = array_keys($this->units);
            $currentNumber = 1;
            $currentIndex  = array_search(strtolower($this->unit), $units);

            if ($currentIndex > 0) {
                $units = array_slice($units, $currentIndex);
            }


            foreach ($units as $unit) {
                $steps[$currentNumber]   = $unit;
                $currentNumber = $currentNumber * $this->jump;
            }
            $this->steps = $steps;
        }
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

    protected function getPluralFormat()
    {
        return $this->pluralFormat;
    }

    public function getUnitDisplay($unit, $plural = false)
    {
        $unitDisplay = $this->displayFullUnitName && isset($this->units[$unit]) ? $this->units[$unit] : $unit;
        if ($plural) {
            return sprintf($this->getPluralFormat(), ucfirst($unitDisplay));
        }
        return ucfirst($unitDisplay);
    }
}
