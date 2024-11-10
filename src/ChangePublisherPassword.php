<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ChangePublisherPassword implements PageInterface
{
    public function __construct(private Config $config)
    {
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        if (isset($_POST['save']) && !empty($_POST['password'])) {
            if ($this->config->demo()) {
                $placeholder['message']['error'] = __('Passwords cannot be changed in the demo version!');
            } else {
                if ($_POST['password'] == $_POST['password_repeat']) {
                    if (Tables\Publisher::update_password($database_pdo, $_SESSION['publisher_id'], $_POST['password'])) {
                        $placeholder['message']['success'] = __('Your password has been changed successfully.');
                    } else {
                        $placeholder['message']['error'] = __('Your password could not be changed!');
                    }
                } else {
                    $placeholder['message']['error'] = __('Passwords do not match!');
                }
            }
        }

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                $render_page($placeholder, 'profile-password.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
