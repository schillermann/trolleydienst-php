<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublisherProfilePage implements PageInterface
{
    function __construct(private Config $config) {}

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        if (isset($_POST['save'])) {
            if ($this->config->demo()) {
                $placeholder['message']['error'] = __('The profile cannot be changed in the demo version!');
            } else {
                $profile_filter_post_input = include '../modules/filter_post_input.php';
                $profile_update = new Models\Profile($_SESSION['publisher_id'], $profile_filter_post_input());

                if (Tables\Publisher::update_profile($database_pdo, $profile_update))
                    $placeholder['message']['success'] = __('Your profile has been successfully updated.');
                else
                    $placeholder['message']['error'] = __('Your profile could not be updated!');
            }
        }

        $placeholder['profile'] = Tables\Publisher::select_profile($database_pdo, $_SESSION['publisher_id']);
        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'profile.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
