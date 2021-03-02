<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class BinaryScale extends Scale
{
    const SCALE_NAME = 'binary';

    protected $unit = 'b';

    protected $steps = array(

    );

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
