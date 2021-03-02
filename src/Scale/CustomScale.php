<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class CustomScale extends Scale
{
    const SCALE_NAME = 'custom';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
