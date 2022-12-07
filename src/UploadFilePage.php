<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class UploadFilePage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        if(isset($_POST['upload'])) {
            if(DEMO) {
                $placeholder['message']['error'] = __('Files cannot be uploaded in the demo version!');
            } else {
                $upload_info_file = include '../services/upload_info_file.php';
                if($upload_info_file(
                    $database_pdo,
                    include '../filters/post_info_file_label.php',
                    $_FILES['file']['tmp_name'],
                    $_FILES['file']['type'],
                    $_FILES['file']['size']
                ))
                    $placeholder['message']['success'] = __('The file was uploaded successfully.');
            else
                    $placeholder['message']['error'] = __('The file could not be uploaded!');
            }
        }

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'info-add.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}