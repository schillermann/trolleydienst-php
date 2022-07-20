<?php
namespace App;

use PhpPages\FormDataInterface;
use PhpPages\StorageVeil;

class PublisherFormData
{
    private FormDataInterface $formData;
    private PublisherPoolInterface $publisherPool;

    function __construct(FormDataInterface $formData, PublisherPoolInterface $publisherPool)
    {
        $this->formData = $formData;
        $this->publisherPool = $publisherPool;
    }
    function user(): StorageVeil
    {
        return $this->publisherPool->publisherActiveByUsernameOrEmailAndPassword(
            $this->formData->param('email_or_username'),
            $this->formData->param('password')
        );
    }
}