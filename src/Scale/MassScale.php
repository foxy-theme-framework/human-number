<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class MassScale extends Scale
{
    const SCALE_NAME = 'mass';

    protected $unit = 'kg';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
