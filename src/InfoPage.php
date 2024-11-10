<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class InfoPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';
        $placeholder['file_list'] = Tables\Infos::select_all($database_pdo);

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                $render_page($placeholder, 'info.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
