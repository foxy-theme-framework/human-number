<?php
function human_friendly_numbers($number = null, $scale = null, $locate = null) {
    return \Ramphor\FriendlyNumbers\Parser::parse($number, $scale, $locate);
}
