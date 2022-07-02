<?php
/**
 * return array('subject' => '...', 'message' => '...')
 */
return function (\PDO $connection, int $id_email_template = App\Tables\EmailTemplates::INFO): array {
    $template = App\Tables\EmailTemplates::select($connection, $id_email_template);
    $templateSubject = $template['subject'];
    $templateMessage = htmlspecialchars_decode($template['message']);

    $replace_with = array(
        'TEAM_NAME' => TEAM_NAME,
        'APPLICATION_NAME' => APPLICATION_NAME,
        'CONGREGATION_NAME' => CONGREGATION_NAME,
        'EMAIL_ADDRESS_REPLY' => EMAIL_ADDRESS_REPLY
    );

    $template_placeholder_replaced = array();
    $template_placeholder_replaced['subject'] = strtr($templateSubject, $replace_with);

    if(strpos($templateMessage, 'SIGNATURE') !== false) {
        $template_signature = App\Tables\EmailTemplates::select($connection, App\Tables\EmailTemplates::SIGNATURE);
        $replace_with['SIGNATURE'] =  strtr($template_signature['message'], $replace_with);
    }

    $template_placeholder_replaced['message'] = strtr($templateMessage, $replace_with);

    return $template_placeholder_replaced;
};