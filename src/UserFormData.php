<?php
namespace App;

use PhpPages\FormDataInterface;

class UserFormData
{
    private FormDataInterface $formData;
    private UserPoolInterface $userPool;

    function __construct(FormDataInterface $formData, UserPoolInterface $userPool)
    {
        $this->formData = $formData;
        $this->userPool = $userPool;
    }
    function user(): UserInterface
    {
        return $this->userPool->userActiveByUsernameOrEmailAndPassword(
            $this->formData->param('email_or_username'),
            $this->formData->param('password')
        );
    }
}