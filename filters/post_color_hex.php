<?php return filter_input(
    INPUT_POST,
    'color_hex',
    FILTER_VALIDATE_REGEXP,
    array(
        'options' => array('regexp' => '/^#[0-9a-fA-F]{3,6}$/i')
    )
);