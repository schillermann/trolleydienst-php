<?php return function ($define_value) {

    switch (gettype($define_value)) {
        case 'integer':
            return $define_value;
        case 'boolean':
            return ($define_value) ? 'true' : 'false';
        default:
            return "'" . $define_value . "'";
    }
};