<?php
namespace App\Shift\Api;

use App\Shift\PublishersInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublishersEnabledQuery implements PageInterface
{
    private PublishersInterface $publishers;

    public function __construct(PublishersInterface $publishers)
    {
        $this->publishers = $publishers;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $publisherList = [];
        foreach ($this->publishers->allActivate() as $publisher) {
            $publisherList[] = [
                "id" => $publisher->id(),
                "name" => $publisher->firstname() . " " . $publisher->lastname()
            ];
        }

        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(
                    $publisherList,
                    JSON_THROW_ON_ERROR,
                    2
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;   
    }
}