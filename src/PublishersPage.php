<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublishersPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        if ( isset($_POST["user_search"]) ) {
            $user_list = Tables\Publisher::select_user_search_name($database_pdo, $_POST["user_search"]);
        } else {
            $user_list = Tables\Publisher::select_all($database_pdo);
        }

        $placeholder['user_list'] = $user_list;

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'user.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}