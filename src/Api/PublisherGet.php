<?php

namespace App\Api;

use App\Database\PublishersSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublisherGet implements PageInterface
{
  private PublishersSqlite $publishers;
  private int $publisherId;

  function __construct(PublishersSqlite $publishers, int $publisherId)
  {
    $this->publishers = $publishers;
    $this->publisherId = $publisherId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $publisher = $this->publishers->publisher($this->publisherId);

    if ($publisher->id() === 0) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    return $output
      ->withMetadata(
        'Content-Type',
        'application/json'
      )
      ->withMetadata(
        PageInterface::BODY,
        json_encode(
          [
            'id' => $publisher->id(),
            'username' => $publisher->username(),
            'firstname' => $publisher->firstname(),
            'lastname' => $publisher->lastname(),
            'email' => $publisher->email(),
            'phone' => $publisher->phone(),
            'mobile' => $publisher->mobile(),
            'congregation' => $publisher->congregation(),
            'language' => $publisher->language(),
            'publisherNote' => $publisher->publisherNote(),
            'active' => $publisher->active(),
            'admin' => $publisher->admin(),
            'loggedOn' => $publisher->loggedOn()->format(\DateTimeInterface::ATOM),
            'updatedOn' => $publisher->updatedOn()->format(\DateTimeInterface::ATOM),
            'createdOn' => $publisher->createdOn()->format(\DateTimeInterface::ATOM)
          ],
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
