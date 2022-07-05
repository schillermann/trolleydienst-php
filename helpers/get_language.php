<?php
if (defined('LANGUAGE')) {
    return LANGUAGE;
} else {
    return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}