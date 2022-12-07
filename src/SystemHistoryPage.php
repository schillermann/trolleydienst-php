<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class SystemHistoryPage implements PageInterface
{

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';
        $placeholder['system_error_list'] = Tables\History::select_all($database_pdo, [Tables\History::SYSTEM_ERROR]);

        $render_page = require('../includes/render_page.php');

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'history-system.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}