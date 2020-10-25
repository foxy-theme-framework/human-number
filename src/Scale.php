<?php
namespace Ramphor\FriendlyNumbers;

class Scale
{
    public $scale;
    public $separator;
    public $unit;

    public function __construct($args = array())
    {
        $args = wp_parse_args($args, array(
            'scale' => 'metric',
            'separator' => ' ',
            'unit' => ''
        ));
        $this->scale = $args['scale'];
        $this->separator = $args['separator'];
        $this->unit = $args['unit'];
    }
}
