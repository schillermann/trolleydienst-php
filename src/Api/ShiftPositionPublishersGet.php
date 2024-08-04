<?php

namespace App\Api;

use App\Database\SlotsSqlite;
use App\Database\PublishersSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublishersGet implements PageInterface
{
  private SlotsSqlite $slots;
  private PublishersSqlite $publishers;
  private int $routeId;
  private int $shiftNumber;

  public function __construct(
    SlotsSqlite $slots,
    PublishersSqlite $publishers,
    int $routeId,
    int $shiftNumber
  ) {
    $this->slots = $slots;
    $this->publishers = $publishers;
    $this->routeId = $routeId;
    $this->shiftNumber = $shiftNumber;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $slots = $this->slots->slots(
      $this->routeId,
      $this->shiftNumber
    );

    $body = [];

    foreach ($slots as $slot) {
      $publisher = $this->publishers->publisher($slot->publisherId());
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
        'admin' => $publisher->admin(),
        'loggedOn' => $publisher->loggedOn()->format(\DateTimeInterface::ATOM),
        'updatedOn' => $publisher->updatedOn()->format(\DateTimeInterface::ATOM),
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
