<?php
namespace App;

class AppConfig implements AppConfigInterface
{
    function congregation(): string
    {
        return 'Demo Versammlung';
    }
}