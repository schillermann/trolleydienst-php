<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class AddShiftTypePage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        if(isset($_POST['save'])) {
            $name = include '../filters/post_name.php';
            $shift_type_info = include '../filters/post_shift_type_info.php';
            $user_per_shift_max = (int)$_POST['user_per_shift_max'];

            if(Tables\ShiftTypes::insert($database_pdo, $name, $shift_type_info, $user_per_shift_max))
                $placeholder['message']['success'] = __('The new shift type was added successfully.');
            else
                $placeholder['message']['error'] = __('The new shift type could not be added!');
        }

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'shifttype-add.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}