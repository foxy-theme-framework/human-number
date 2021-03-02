<?php
namespace Ramphor\FriendlyNumbers;

use Ramphor\FriendlyNumbers\Abstracts\Scale;
use Ramphor\FriendlyNumbers\Scale\DefaultScale;
use Ramphor\FriendlyNumbers\Scale\BinaryScale;
use Ramphor\FriendlyNumbers\Scale\TimeScale;
use Ramphor\FriendlyNumbers\Scale\CurrencyScale;
use Ramphor\FriendlyNumbers\Scale\LengthScale;
use Ramphor\FriendlyNumbers\Scale\MassScale;
use Ramphor\FriendlyNumbers\Scale\AcreScale;

class Parser
{
    protected static $locate;
    protected $scale;
    protected $raw;
    protected $value;
    protected $prefix;
    protected $parsed = false;

    protected static $_builtinScales = array(
        'default'  => DefaultScale::class,
        'binary'   => BinaryScale::class,
        'time'     => TimeScale::class,
        'currency' => CurrencyScale::class,
        'length'   => LengthScale::class,
        'mass'     => MassScale::class,
        'acre'     => AcreScale::class,
    );

    public function __construct($number = null, $scale = null, $locate = null)
    {
        $this->raw = $number;

        $this->createScale($scale);
    }

    public function createScale($scale)
    {
        if (is_a($scale, Scale::class)) {
            return $this->scale = $scale;
        }
    }

    public function _parse()
    {
        $this->scale->sortSteps();

        $allSteps  = $this->scale->getSteps();
        $stepKeys  = array_keys($allSteps);
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
