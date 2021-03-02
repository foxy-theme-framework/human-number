<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class DefaultScale extends Scale
{
    const SCALE_NAME = 'default';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
