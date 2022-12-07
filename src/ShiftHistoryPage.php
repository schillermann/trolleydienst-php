<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftHistoryPage implements PageInterface
{

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        $get_history_shift = require('../services/get_history_shift.php');
        $shift_history_list = $get_history_shift($database_pdo);

        $placeholder['shift_error_list'] = [];
        $placeholder['shift_success_list'] = [];

        if(isset($shift_history_list['error']))
            $placeholder['shift_error_list'] = $shift_history_list['error'];
        if(isset($shift_history_list['success']))
            $placeholder['shift_success_list'] = $shift_history_list['success'];

        $render_page = require('../includes/render_page.php');

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'history-shift.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}