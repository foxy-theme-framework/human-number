<?php
namespace Ramphor\FriendlyNumbers\Scale;

use Ramphor\FriendlyNumbers\Abstracts\Scale;

class CurrencyScale extends Scale
{
    const SCALE_NAME = 'currencty';

    public function get_name()
    {
        return static::SCALE_NAME;
    }
}
