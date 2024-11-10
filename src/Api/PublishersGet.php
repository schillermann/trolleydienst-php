<?php

namespace App\Api;

use App\Database\PublishersSqlite;
use App\UserSession;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublishersGet implements PageInterface
{
    private UserSession $userSession;
    private PublishersSqlite $publishers;
    private bool $filterActivePublishers;
    private string $searchNameOrEmail;
    private int $pageNumber;
    private int $pageItems;

    public function __construct(
        UserSession $userSession,
        PublishersSqlite $publishers,
        bool $filterActivePublishers = false,
        string $searchNameOrEmail = '',
        int $pageNumber = 0,
        int $pageItems = 10
    ) {
        $this->userSession = $userSession;
        $this->publishers = $publishers;
        $this->filterActivePublishers = $filterActivePublishers;
        $this->searchNameOrEmail = $searchNameOrEmail;
        $this->pageNumber = $pageNumber;
        $this->pageItems = $pageItems;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['error' => 'You need admin permission'])
            );
        }

        $offset = ($this->pageNumber - 1) * $this->pageItems;
        $limit = $this->pageItems;

        if ($this->filterActivePublishers) {
            $publishers = $this->publishers->publishersFilterActive($offset, $limit);
        } elseif ($this->searchNameOrEmail) {
            $publishers = $this->publishers->publishersByNameOrEmail($offset, $limit, $this->searchNameOrEmail);
        } else {
            $publishers = $this->publishers->publishers(
                $offset,
                $limit
            );
        }

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
              'language' => $publisher->languages(),
              'publisherNote' => $publisher->publisherNote(),
              'adminNote' => $publisher->adminNote(),
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
              PageInterface::METADATA_BODY,
              json_encode($body)
          );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::METADATA_QUERY) {
            $query = new SimpleFormData($value);

            return new self(
                $this->userSession,
                $this->publishers,
                (bool)$query->param('active'),
                $query->param('search'),
                (int)$query->paramWithDefault('page-number', '1'),
                (int)$query->paramWithDefault('page-items', '10'),
            );
        }

        return $this;
    }
}
