<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class UserDetailsPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if(!isset($_GET['id_user'])) {
            header('location: /shift');
            exit;
        }
        
        $placeholder = require '../includes/init_page.php';
        $id_user = (int)$_GET['id_user'];
        $user = Tables\Publisher::select_user($database_pdo, $id_user);
        $placeholder['user'] = $user;
        
        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'user-details.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}