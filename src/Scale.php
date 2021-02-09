<?php
namespace Ramphor\FriendlyNumbers;

class Scale
{
    protected $steps    = array();
    protected $decimals = 2;

    protected $decimal_separator;
    protected $thousands_separator;

    public function __construct($args = array())
    {
        $args = wp_parse_args($args, array(
            'scale' => null,
            'decimals' => 2,
            'decimal_separator' => '.',
            'thousands_separator' => ','
        ));
        if (is_array($args['scale'])) {
            $this->steps = $args['scale'];
        } else {
            $callable = array(__CLASS__, 'createScale' . ucfirst(trim($args['scale'])));
            if (is_callable($callable)) {
                $this->steps = call_user_func($callable);
            } else {
                $this->steps = static::createScaleDefault();
            }
        }
        $this->decimals = $args['decimals'];
        $this->decimal_separator = $args['decimal_separator'];
        $this->thousands_separator = $args['thousands_separator'];
    }

    public static function createScaleDefault()
    {
        return array(
            1000000 => 'triệu',
            1000000000 => 'tỷ'
        );
    }

    public static function createScaleMetric()
    {
        return array(
            1 => 'm2',
            10000 => 'ha'
        );
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
}
