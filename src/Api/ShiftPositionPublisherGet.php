<?php

namespace App\Api;

use App\Database\ApplicationsSqlite;
use App\Database\PublishersSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublisherGet implements PageInterface
{
  private ApplicationsSqlite $applications;
  private PublishersSqlite $publishers;
  private int $shiftId;
  private int $shiftPositionId;
  private int $publisherId;

  public function __construct(ApplicationsSqlite $applications, PublishersSqlite $publishers, int $shiftId, int $shiftPositionId, int $publisherId)
  {
    $this->applications = $applications;
    $this->publishers = $publishers;
    $this->shiftId = $shiftId;
    $this->shiftPositionId = $shiftPositionId;
    $this->publisherId = $publisherId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $application = $this->applications->application($this->shiftId, $this->shiftPositionId, $this->publisherId);

    if ($application->shiftId() === 0) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

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
        json_encode([
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
          'adminNote' => $publisher->adminNote(),
          'active' => $publisher->active(),
          'administrative' => $publisher->administrative(),
          'loggedOn' => $publisher->loggedOn()->format(\DateTimeInterface::ATOM),
          'updatedOn' => $publisher->updatedOn()->format(\DateTimeInterface::ATOM),
          'createdOn' => $publisher->CreatedOn()->format(\DateTimeInterface::ATOM)
        ])
      );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    return $this;
  }
}
