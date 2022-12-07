<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class AdjustShiftPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if(!isset($_GET['id_shift_type']) || !isset($_GET['id_shift'])) {
            header('location: /shift');
            exit;
        }
        $id_shift_type = (int)$_GET['id_shift_type'];
        $id_shift = (int)$_GET['id_shift'];
        $placeholder = require '../includes/init_page.php';
        
        if (isset($_POST['save'])) {
            $date_from = include '../filters/post_date_from.php';
            $merge_date_and_time = include '../modules/merge_date_and_time.php';
            $shift_datetime_from = $merge_date_and_time($date_from, $_POST['time_from']);
        
            $shift = new Models\Shift(
                $id_shift,
                $id_shift_type,
                include '../filters/post_route.php',
                $shift_datetime_from,
                0,
                $_POST['hours_per_shift'] * 60,
                include '../filters/post_color_hex.php'
            );
        
            if(Tables\Shifts::update($database_pdo, $shift))
                $placeholder['message']['success'] = __('The shift has been changed.');
            else
                $placeholder['message']['error'] = __('The shift could not be changed!');
        } elseif (isset($_POST['delete'])) {
            $delete_shift = include '../services/delete_shift.php';
        
            if($delete_shift($database_pdo, $id_shift)) {
                header('location: /shift?id_shift_type=' . $id_shift_type);
                exit;
            } else {
                $placeholder['message']['error'] = __('The shift could not be deleted!');
            }
        }
        
        $placeholder['id_shift_type'] = $id_shift_type;
        
        $shift = Tables\Shifts::select($database_pdo, $id_shift);
        $placeholder['route'] = $shift['route'];
        $placeholder['number'] = $shift['number'];
        $placeholder['hours_per_shift'] = $shift['minutes_per_shift'] / 60;
        $placeholder['color_hex'] = $shift['color_hex'];
        
        $datetime_from = explode(' ', $shift['datetime_from']);
        $placeholder['date_from'] = $datetime_from[0];
        $placeholder['time_from'] = $datetime_from[1];
        
        $updated = new \DateTime($shift['updated']);
        $created = new \DateTime($shift['created']);
        $placeholder['updated'] = $updated->format(__('d/m/Y') . ' H:i');
        $placeholder['created'] = $created->format(__('d/m/Y') . ' H:i');
        
        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'shift-edit.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}