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
  private int $shiftPositionId;

  public function __construct(
    ApplicationsSqlite $applications,
    PublishersSqlite $publishers,
    int $shiftId,
    int $shiftPositionId
  ) {
    $this->applications = $applications;
    $this->publishers = $publishers;
    $this->shiftId = $shiftId;
    $this->shiftPositionId = $shiftPositionId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $applications = $this->applications->applications(
      $this->shiftId,
      $this->shiftPositionId
    );

    $body = [];

    foreach ($applications as $application) {
      $publisher = $this->publishers->publisher($application->publisherId());
      $body[] = [
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
        'lastLoggedOn' => $publisher->lastLoggedOn()->format(\DateTimeInterface::ATOM),
        'lastModifiedOn' => $publisher->LastModifiedOn()->format(\DateTimeInterface::ATOM),
        'createdOn' => $publisher->CreatedOn()->format(\DateTimeInterface::ATOM)
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
