<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class BinaryScale extends Scale
{
    const SCALE_NAME = 'binary';

    protected $unit = 'b';
    protected $jump  = 1024;
    protected $units = array(
        'b' => 'byte',
        'kb' => 'kilobyte',
        'mb' => 'megabyte',
        'gb' => 'gigabyte',
        'tb' => 'terabyte'
    );

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
