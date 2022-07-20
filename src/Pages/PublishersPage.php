<?php
namespace App\Pages;

use App\PublisherPoolInterface;
use PhpPages\Form\SimpleFormData;
use PhpPages\LanguageInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\TemplateInterface;

class PublishersPage implements PageInterface
{
    private TemplateInterface $template;
    private LanguageInterface $language;
    private PublisherPoolInterface $publisherPool;
    private string $sortColumn;
    private string $sortOrder;
    private string $searchPattern;

    const SORT_COLUMNS = [
        'first_name',
        'last_name',
        'email',
        'active',
        'administrative',
        'logged_on'
    ];

    const SORT_ORDER = ['asc', 'desc'];

    function __construct(
        TemplateInterface $template,
        LanguageInterface $language,
        PublisherPoolInterface $publisherPool,
        string $sortColumn = '',
        string $sortOrder = '',
        string $searchPattern = ''
    ) {
        $this->template = $template;
        $this->language = $language;
        $this->publisherPool = $publisherPool;
        $this->sortColumn = $sortColumn;
        $this->sortOrder = $sortOrder;
        $this->searchPattern = $searchPattern;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        $sortColumn = ($this->sortColumn)? $this->sortColumn : self::SORT_COLUMNS[0];
        $sortOrder = ($this->sortOrder)? $this->sortOrder : self::SORT_ORDER[0];

        if ($this->searchPattern) {
            $users = $this->publisherPool->allByNameOrEmail(
                $this->searchPattern,
                $sortColumn,
                $sortOrder
            );
        } else {
            $users = $this->publisherPool->all(
                $sortColumn,
                $sortOrder
            );
        }

        return $output
            ->withMetadata(
                'PhpPages-Body',
                $this->template
                    ->withParam('language', $this->language)
                    ->withParam('searchPattern', $this->searchPattern)
                    ->withParam('users', $users)
                    ->withParam('sortColumn', $this->sortColumn)
                    ->withParam('sortOrder', $this->sortOrder)
                    ->content()
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === 'PhpPages-Query') {
            if (empty($value)) {
                return new PublishersPage(
                    $this->template,
                    $this->language,
                    $this->publisherPool,
                    $this->sortColumn,
                    $this->sortOrderDesc
                );
            }

            $query = new SimpleFormData($value);

            if (!empty($query->param('sortcolumn')) && !in_array($query->param('sortcolumn'), self::SORT_COLUMNS)) {
                throw new \InvalidArgumentException();
            }

            if (!empty($query->param('sortorder')) && !in_array($query->param('sortorder'), self::SORT_ORDER)) {
                throw new \InvalidArgumentException();
            }

            return new PublishersPage(
                $this->template,
                $this->language,
                $this->publisherPool,
                $query->param('sortcolumn'),
                $query->param('sortorder'),
                $query->param('search')
            );
        }

        return $this;
    }
}