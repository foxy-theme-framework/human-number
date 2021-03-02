<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class AcreScale extends Scale
{
    const SCALE_NAME = 'acre';

    protected $unit = 's';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
