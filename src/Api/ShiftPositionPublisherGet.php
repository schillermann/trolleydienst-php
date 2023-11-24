<?php

namespace App\Api;

use App\Database\PublishersSqlite;
use App\Database\ShiftsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublisherGet implements PageInterface
{
  private ShiftsSqlite $shifts;
  private PublishersSqlite $publishers;
  private int $shiftId;
  private int $shiftPositionId;
  private int $publisherId;

  public function __construct(ShiftsSqlite $shifts, PublishersSqlite $publishers, int $shiftId, int $shiftPositionId, int $publisherId)
  {
    $this->shifts = $shifts;
    $this->publishers = $publishers;
    $this->shiftId = $shiftId;
    $this->shiftPositionId = $shiftPositionId;
    $this->publisherId = $publisherId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shift = $this->shifts->shift($this->shiftId);

    if ($shift->id() === 0 || $shift->positions() < $this->shiftPositionId) {
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
          'shift' => [
            'id' => $shift->id(),
            'typeId' => $shift->typeId(),
            'routeName' => $shift->routeName(),
            'start' => $shift->start()->format(\DateTimeInterface::ATOM),
            'positions' => $shift->positions(),
            'minutesPerShift' => $shift->minutesPerShift(),
            'colorHex' => $shift->colorHex(),
            'updatedAt' => $shift->updatedAt()->format(\DateTimeInterface::ATOM),
            'createdAt' => $shift->createdAt()->format(\DateTimeInterface::ATOM)
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
            'publisherNote' => $publisher->publisherNote(),
            'adminNote' => $publisher->adminNote(),
            'active' => $publisher->active(),
            'administrative' => $publisher->administrative(),
            'loggedInAt' => $publisher->loggedInAt()->format(\DateTimeInterface::ATOM),
            'updatedAt' => $publisher->updatedAt()->format(\DateTimeInterface::ATOM),
            'createdAt' => $publisher->createdAt()->format(\DateTimeInterface::ATOM)
          ]
        ])
      );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    return $this;
  }
}
