<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class UpdatePage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        require __DIR__ . '/../vendor/autoload.php';
        include '../includes/language.php';

        if (!Tables\Database::exists_database()) {
            header('location: /install.php');
            exit;
        }

        include '../config.php';
        $database_pdo = Tables\Database::get_connection();
        $placeholder = [];

        if ($_POST) {
            $get_database_version = include '../services/get_database_version.php';
            $update = include '../services/update.php';

            try {
                $database_version = $get_database_version($database_pdo);
                $success_migrations = $update($database_pdo, $database_version);

                if ($success_migrations) {
                    $placeholder['message']['success']  =
                        __('The following database migrations were carried out successfully: ') . implode(', ', $success_migrations);
                } else {
                    $placeholder['message']['success'] = __('The database is up to date.');
                }
            } catch (\Exception $exc) {
                $placeholder['message']['error'] = $exc->getMessage();
            }
        }
        $is_uptodate = include '../services/is_uptodate.php';
        $placeholder['is_up_to_date'] = $is_uptodate($database_pdo);

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                $render_page($placeholder, 'update.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
