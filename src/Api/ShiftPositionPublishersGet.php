<?php

namespace App\Api;

use App\Database\ApplicationsSqlite;
use App\Database\PublishersSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublishersGet implements PageInterface
{
  private ApplicationsSqlite $applications;
  private PublishersSqlite $publishers;
  private int $shiftId;
  private int $positionId;

  public function __construct(
    ApplicationsSqlite $applications,
    PublishersSqlite $publishers,
    int $shiftId,
    int $positionId
  ) {
    $this->applications = $applications;
    $this->publishers = $publishers;
    $this->shiftId = $shiftId;
    $this->positionId = $positionId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $applications = $this->applications->applications(
      $this->shiftId,
      $this->positionId
    );

    $body = [];

    foreach ($applications as $application) {
      $publisher = $this->publishers->publisher($application->publisherId());
      $body[] = [
        'application' => [
          'shiftId' => $application->shiftId(),
          'publisherId' => $application->publisherId(),
          'positionId' => $application->positionId(),
          'createdAt' => $application->createdAt()->format(\DateTimeInterface::ATOM)
        ],
        'publisher' => [
          'id' => $publisher->id(),
          'username' => $publisher->username(),
          'firstname' => $publisher->firstname(),
          'lastname' => $publisher->lastname(),
          'email' => $publisher->email(),
          'phone' => $publisher->phone(),
          'mobile' => $publisher->mobile(),
          'congregation' => $publisher->congregation(),
          'language' => $publisher->language(),
          'active' => $publisher->active(),
          'administrative' => $publisher->administrative(),
          'loggedInAt' => $publisher->loggedInAt()->format(\DateTimeInterface::ATOM),
          'updatedAt' => $publisher->updatedAt()->format(\DateTimeInterface::ATOM),
          'createdAt' => $publisher->createdAt()->format(\DateTimeInterface::ATOM)
        ]
      ];
    }

    return $output
      ->withMetadata(
        'Content-Type',
        'application/json'
      )
      ->withMetadata(
        PageInterface::BODY,
        json_encode($body)
      );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    return $this;
  }
}
