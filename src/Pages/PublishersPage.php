<?php
namespace App\Pages;

use App\PublisherPoolInterface;
use PhpPages\Form\SimpleFormData;
use PhpPages\LanguageInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\SessionInterface;
use PhpPages\TemplateInterface;

class PublishersPage implements PageInterface
{
    private TemplateInterface $template;
    private LanguageInterface $language;
    private PublisherPoolInterface $publisherPool;
    private SessionInterface $session;
    private string $sortColumn;
    private bool $sortDesc;
    private string $searchPattern;

    const SORT_COLUMNS = [
        'first_name',
        'last_name',
        'email',
        'active',
        'administrative',
        'logged_on'
    ];

    const SORT_COLUMN_DEFAULT = self::SORT_COLUMNS[0];

    function __construct(
        TemplateInterface $template,
        LanguageInterface $language,
        PublisherPoolInterface $publisherPool,
        SessionInterface $session,
        string $sortColumn = '',
        bool $sortDesc = false,
        string $searchPattern = ''
    ) {
        $this->template = $template;
        $this->language = $language;
        $this->publisherPool = $publisherPool;
        $this->session = $session;
        $this->sortColumn = $sortColumn;
        $this->sortDesc = $sortDesc;
        $this->searchPattern = $searchPattern;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        $sortOrder = ($this->sortDesc)? 'desc' : 'asc';

        if ($this->searchPattern) {
            $users = $this->publisherPool->allByNameOrEmail(
                $this->searchPattern,
                $this->sortColumn,
                $sortOrder
            );
        } else {
            $users = $this->publisherPool->all(
                $this->sortColumn,
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
                    ->content()
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === 'PhpPages-Query') {

            $query = new SimpleFormData($value);
            $sortColumn = $query->param('sort');

            if ($query->exists('search')) {
                $this->session->add('publishersPageSearchPattern', $query->param('search'));
            } else if ($sortColumn && $this->session->param('publishersPageSortColumn') === $sortColumn) {
                $this->session->add('publishersPageSortDesc', (string)!$this->session->param('publishersPageSortDesc'));
            } else {
                $sortColumn = $sortColumn? $sortColumn : self::SORT_COLUMN_DEFAULT;
                $this->session->add('publishersPageSortColumn', $sortColumn);
                $this->session->add('publishersPageSortDesc', (string)false);
            }

            return new PublishersPage(
                $this->template,
                $this->language,
                $this->publisherPool,
                $this->session,
                $this->session->param('publishersPageSortColumn'),
                (bool)$this->session->param('publishersPageSortDesc'),
                $this->session->param('publishersPageSearchPattern')
            );
        }

        return $this;
    }
}