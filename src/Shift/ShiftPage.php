<?php

namespace App\Shift;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        if (!isset($_GET['id_shift_type'])) {
            $id_shift_type = ShiftTypeTable::select_first_id_shift_type($database_pdo);
            if ($id_shift_type) {
                header('location: /shift?id_shift_type=' . $id_shift_type);
            } else {
                header('location: /info');
            }
            exit;
        }

        $placeholder['id_shift_type'] = (int)$_GET['id_shift_type'];
        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'shift.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
