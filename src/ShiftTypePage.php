<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftTypePage implements PageInterface
{

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';
        $placeholder['shift_type_list'] = Shift\ShiftTypeTable::select_all($database_pdo);

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'shifttype.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}