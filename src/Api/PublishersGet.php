<?php

namespace App\Api;

use App\Database\PublishersSqlite;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublishersGet implements PageInterface
{
  private PublishersSqlite $publishers;
  private bool $filterActivePublishers;
  private int $pageNumber;
  private int $pageItems;

  public function __construct(
    PublishersSqlite $publishers,
    bool $filterActivePublishers = false,
    int $pageNumber = 0,
    int $pageItems = 10
  ) {
    $this->publishers = $publishers;
    $this->filterActivePublishers = $filterActivePublishers;
    $this->pageNumber = $pageNumber;
    $this->pageItems = $pageItems;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $offset = ($this->pageNumber - 1) * $this->pageItems;
    $limit = $this->pageItems;

    $publishers = $this->filterActivePublishers ?
      $this->publishers->publishersFilterActive($offset, $limit) :
      $publishers = $this->publishers->publishers(
        $offset,
        $limit
      );

    $body = [];
    foreach ($publishers as $publisher) {
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
        'publisherNote' => $publisher->publisherNote(),
        'adminNote' => $publisher->adminNote(), // TODO: Display only by admin user
        'active' => $publisher->active(),
        'admin' => $publisher->admin(),
        'loggedOn' => $publisher->loggedOn()->format(\DateTimeInterface::ATOM),
        'updatedOn' => $publisher->updatedOn()->format(\DateTimeInterface::ATOM),
        'createdOn' => $publisher->createdOn()->format(\DateTimeInterface::ATOM)
      ];
    }

    $pagesTotalNumber = $this->publishers->publishersTotalNumber();
    $itemNumberFrom = (($this->pageNumber - 1) * $this->pageItems) + 1;
    $itemNumberTo = $this->pageNumber * $this->pageItems;
    if ($itemNumberTo > $pagesTotalNumber) {
      $itemNumberTo = $pagesTotalNumber;
    }

    return $output
      ->withMetadata(
        'Accept-Ranges',
        'count'
      )
      ->withMetadata(
        'Content-Range',
        "count $itemNumberFrom -$itemNumberTo/$pagesTotalNumber"
      )
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
    if ($name === PageInterface::QUERY) {
      $query = new SimpleFormData($value);

      return new self(
        $this->publishers,
        (bool)$query->param('active'),
        (int)$query->paramWithDefault('page-number', '1'),
        (int)$query->paramWithDefault('page-items', '10'),
      );
    }

    return $this;
  }
}
