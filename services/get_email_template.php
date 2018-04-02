<?php
/**
 * return array('subject' => '...', 'message' => '...')
 */
return function (\PDO $connection, int $id_email_template = Tables\EmailTemplates::INFO): array {
    $template = Tables\EmailTemplates::select($connection, $id_email_template);

    $replace_with = array(
        'TEAM_NAME' => TEAM_NAME,
        'APPLICATION_NAME' => APPLICATION_NAME,
        'CONGREGATION_NAME' => CONGREGATION_NAME,
        'EMAIL_ADDRESS_REPLY' => EMAIL_ADDRESS_REPLY
    );

    $template_placeholder_replaced = array();
    $template_placeholder_replaced['subject'] = strtr($template['subject'], $replace_with);

    if(strpos($template['message'], 'SIGNATURE') !== false) {
        $template_signature = Tables\EmailTemplates::select($connection, Tables\EmailTemplates::SIGNATURE);
        $replace_with['SIGNATURE'] =  strtr($template_signature['message'], $replace_with);
    }

    $template_placeholder_replaced['message'] = strtr($template['message'], $replace_with);

    return $template_placeholder_replaced;
};