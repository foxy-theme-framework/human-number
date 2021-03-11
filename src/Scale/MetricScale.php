<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class MetricScale extends Scale
{
    const SCALE_NAME = 'acre';

    protected $units = array(
        '' => 'm'
    );
    protected $unit = 'm';
    protected $submultiples = '';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
