<?php
function replacenull($value, $replace="") {
    if (is_null($value)) return trim($replace);
    return trim($value);
}
?>