<?php
namespace Ramphor\FriendlyNumbers\Abstracts;

use Ramphor\FriendlyNumbers\Interfaces\ScaleInterface;

abstract class Scale implements ScaleInterface {
    protected $steps = array();

    public function getSteps() {
        return $this->steps;
    }
}
