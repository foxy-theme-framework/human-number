<?php
namespace Ramphor\FriendlyNumbers;

use JsonSerializable;

class Scale
{
    protected $steps = array();

    public function __construct($args = array())
    {
        $args = wp_parse_args($args, array(
            'scale' => null,
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
        asort($this->steps);
    }

    public function getSteps()
    {
        return $this->steps;
    }
}
