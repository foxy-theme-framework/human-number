<?php
namespace Ramphor\FriendlyNumbers\Abstracts;

use Ramphor\FriendlyNumbers\Interfaces\ScaleInterface;

abstract class Scale implements ScaleInterface
{
    protected $decimals = 2;
    protected $unit = '';
    protected $decimal_separator;
    protected $thousands_separator;

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

    public function _parse()
    {
        $this->scale->sortSteps();
        $allSteps = $this->scale->getSteps();
        $stepKeys = array_keys($allSteps);
        $totalStep = count($stepKeys);

        foreach ($stepKeys as $index => $step) {
            if ($this->parsed) {
                break;
            }
            $cal = $this->raw / $step;

            if ($cal >= 1) {
                $this->value = $cal;
                $this->prefix = $allSteps[$step];
                if ($index >= $totalStep - 1) {
                    $this->parsed = true;
                }
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

        $roundedPrice = number_format(
            $this->value,
            $this->scale->getDecimals(),
            $this->scale->getDecimalSeparator(),
            $this->scale->getThousandsSeparator()
        );
        return array(
            'value'  => preg_replace('/\.0{1,}$/', '', $roundedPrice),
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
