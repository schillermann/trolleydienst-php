<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class EditFilePage implements PageInterface
{
    function __construct(private Config $config) {}

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (!isset($_GET['id_info'])) {
            header('location: /info');
            exit;
        }

        $placeholder = require '../includes/init_page.php';
        $id_info = (int)$_GET['id_info'];

        if (isset($_POST['delete'])) {

            if ($this->config->demo()) {
                $placeholder['message']['error'] = __('Files cannot be deleted in the demo version!');
            } else {
                if (Tables\Infos::delete($database_pdo, $id_info)) {
                    header('location: /info');
                    exit;
                }
                $file_label = include '../filters/post_info_file_label.php';
                $placeholder['message']['error'] = __('The file %s could not be deleted!', [$file_label]);
            }
        } elseif (isset($_POST['save'])) {

            if ($this->config->demo()) {
                $placeholder['message']['error'] = __('Files cannot be edited in the demo version!');
            } else {
                $file_label = include '../filters/post_info_file_label.php';

                if ($file_label)
                    if (Tables\Infos::update($database_pdo, $id_info, $file_label))
                        $placeholder['message']['success'] = __('The file %s has been renamed.', [$file_label]);
                    else
                        $placeholder['message']['error'] = __('The file %s could not be renamed!', [$file_label]);
            }
        }

        $placeholder['info_file_label'] = Tables\Infos::select_label($database_pdo, $id_info);

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'info-edit.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
