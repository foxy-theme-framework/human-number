<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class LengthScale extends Scale
{
    const SCALE_NAME = 'length';

    protected $unit = 'm';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
