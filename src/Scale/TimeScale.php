<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class TimeScale extends Scale
{
    const SCALE_NAME = 'time';

    protected $unit = 's';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
