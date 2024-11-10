<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class EmailTemplatesPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';

        if (!isset($_GET['id_email_template'])) {
            header('location: /newsletter');
            exit;
        }

        $id_email_template = (int)$_GET['id_email_template'];

        if (isset($_POST['save'])) {
            $template_email_subject = require('../filters/post_template_email_subject.php');
            $template_email_message = require('../filters/post_template_email_message.php');

            if (Tables\EmailTemplates::update($database_pdo, $id_email_template, $template_email_message, $template_email_subject)) {
                $placeholder['message']['success'] = __('The template %s has been saved.', [ $template_email_subject ]);
            } else {
                $placeholder['message']['error'] = __('The template %s could not be saved!', [ $template_email_subject ]);
            }
        }

        $placeholder['email_templates'] = Tables\EmailTemplates::select_all($database_pdo);
        $placeholder['selected_template'] = Tables\EmailTemplates::select($database_pdo, $id_email_template);
        $placeholder['id_email_template'] = $id_email_template;

        $render_page = require('../includes/render_page.php');

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                $render_page($placeholder, 'email-templates.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
