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
use Ramphor\FriendlyNumbers\Exceptions\ScaleException;
use Ramphor\FriendlyNumbers\Exceptions\ParseException;

class Parser
{
    protected static $locate;
    protected $scale;
    protected $raw;
    protected $value;
    protected $prefix;
    protected $parsed = false;

    protected static $_builtinScales = array(
        DefaultScale::SCALE_NAME  => DefaultScale::class,
        BinaryScale::SCALE_NAME   => BinaryScale::class,
        TimeScale::SCALE_NAME     => TimeScale::class,
        CurrencyScale::SCALE_NAME => CurrencyScale::class,
        LengthScale::SCALE_NAME   => LengthScale::class,
        MassScale::SCALE_NAME     => MassScale::class,
        AcreScale::SCALE_NAME     => AcreScale::class,
    );

    public function __construct($number = null, $scale = null, $locate = null)
    {
        $this->raw = $number;
        $this->createScale($scale);
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function createScale($scale)
    {
        if (is_a($scale, Scale::class)) {
            return $this->scale = $scale;
        }

        $scaleName = false;
        if (is_string($scale)) {
            $scaleName = $scale;
        } elseif (is_array($scale) && isset($scale['scale'])) {
            $scaleName = $scale['scale'];
        }

        if ($scaleName) {
            if (!isset(static::$_builtinScales[$scaleName])) {
                throw new ScaleException(
                    sprintf('Scale "%s" is not built in', $scaleName),
                    ScaleException::ERROR_INVALID_SCALE
                );
            }
            $scaleCls = static::$_builtinScales[$scaleName];
            $this->scale = new $scaleCls();

            if (is_array($scale)) {
                if (isset($scale['unit'])) {
                    $this->scale->setUnit($scale['unit']);
                }
            }
            return $this->scale;
        }
    }

    public function _parse()
    {
        if (is_null($this->scale)) {
            throw new ParseException('The scale is not found', ParseException::ERROR_SCALE_NOT_FOUND);
        }

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

    public function toString()
    {
        if (!$this->parsed) {
            $this->_parse();
        }
    }

    public static function parse($number, $scale, $locale)
    {
        $p = new static($number, $scale, $locale);
        $p->_parse();

        return $p;
    }
}
