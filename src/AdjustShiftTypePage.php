<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class AdjustShiftTypePage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if(!isset($_GET['id_shift_type'])) {
            header('location: /shift-type');
            exit;
        }
        $placeholder = require '../includes/init_page.php';
        $id_shift_type = (int)$_GET['id_shift_type'];
        
        if (isset($_POST['save'])) {
            $name = include '../filters/post_name.php';
            $shift_type_info = include '../filters/post_shift_type_info.php';
            $user_per_shift_max = (int)$_POST['user_per_shift_max'];
        
            if(Tables\ShiftTypes::update($database_pdo, $id_shift_type, $name, $shift_type_info, $user_per_shift_max))
                $placeholder['message']['success'] = __('The changes have been saved.');
            else
                $placeholder['message']['error'] = __('The changes could not be saved!');
        } elseif (isset($_POST['delete'])) {
            if(Tables\ShiftTypes::delete($database_pdo, $id_shift_type)) {
                header('location: /shift-type');
                exit;
            }
        }
        
        $placeholder['shift_type'] = Tables\ShiftTypes::select($database_pdo, $id_shift_type);
        
        $updated = new \DateTime($placeholder['shift_type']['updated']);
        $created = new \DateTime($placeholder['shift_type']['created']);
        $placeholder['shift_type']['updated'] = $updated->format(__('d/m/Y') . ' H:i');
        $placeholder['shift_type']['created'] = $created->format(__('d/m/Y') . ' H:i');
        
        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'shifttype-edit.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}