<?php

namespace App\Api;

use App\AddPublisherPage;
use App\ChangePublisherPassword;
use App\Config;
use App\Database\CalendarsSqlite;
use App\Database\PublishersSqlite;
use App\Database\RoutesSqlite;
use App\Database\SlotsSqlite;
use App\EditFilePage;
use App\EditPublisherPage;
use App\EmailSettingsPage;
use App\EmailTemplatesPage;
use App\FileViewPage;
use App\InfoPage;
use App\InstallPage;
use App\LoginHistoryPage;
use App\NewsletterPage;
use App\PublisherProfilePage;
use App\PublishersPage;
use App\ReportPage;
use App\ResetPasswordPage;
use App\ShiftHistoryPage;
use App\ShiftTypePage;
use App\SubmitReportPage;
use App\SystemHistoryPage;
use App\UpdatePage;
use App\UploadFilePage;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\Page\Request\ConstraintLength;
use PhpPages\Page\Request\ConstraintType;
use PhpPages\Page\Request\RequestProperties;
use PhpPages\PageInterface;

class PostPage implements PageInterface
{
    function __construct(private \PDO $pdo, private UserSession $userSession, private Config $config)
    {
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 404 Not Found'
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if (PageInterface::PATH !== $name) {
            return $this;
        }

        switch ($value) {
            case '/report':
                return new ReportPage();
            case '/submit-report':
                return new SubmitReportPage();
            case '/publisher-profile':
                return new PublisherProfilePage($this->config);
            case '/change-publisher-password':
                return new ChangePublisherPassword($this->config);
            case '/publishers':
                return new PublishersPage();
            case '/add-publisher':
                return new AddPublisherPage($this->config);
            case '/edit-publisher':
                return new EditPublisherPage($this->config);
            case '/newsletter':
                return new NewsletterPage($this->config);
            case '/info':
                return new InfoPage();
            case '/upload-file':
                return new UploadFilePage($this->config);
            case '/file-view':
                return new FileViewPage($this->config);
            case '/edit-file':
                return new EditFilePage($this->config);
            case '/reset-password':
                return new ResetPasswordPage($this->config);
            case '/shift-type':
                return new ShiftTypePage();
            case '/shift-history':
                return new ShiftHistoryPage();
            case '/login-history':
                return new LoginHistoryPage();
            case '/system-history':
                return new SystemHistoryPage();
            case '/email-settings':
                return new EmailSettingsPage();
            case '/email-templates':
                return new EmailTemplatesPage();
            case '/update':
                return new UpdatePage();
            case '/install':
                return new InstallPage();
        }

        if ('/api/emails/send' === $value) {
            return new EmailSendPost(
                $this->config,
                (new RequestProperties())
                ->withPropertyConstraints(
                    'to',
                    new ConstraintType('string'),
                    new ConstraintLength(2, 50)
                )
            );
        }
        if (preg_match('|^/api/calendars/([0-9]+)/shifts$|', $value, $matches) === 1) {
            return new ShiftsPost(
                new RoutesSqlite($this->pdo, (int)$matches[1])
            );
        }
        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)/shifts/([0-9]+)/slots$|', $value, $matches) === 1) {
            return new SlotsPost(
                $this->userSession,
                new SlotsSqlite($this->pdo),
                new RoutesSqlite($this->pdo, (int)$matches[1]),
                new PublishersSqlite($this->pdo),
                (int)$matches[2],
                (int)$matches[3]
            );
        }
        if (preg_match('|^/api/calendars/([0-9]+)/routes$|', $value, $matches) === 1) {
            return new RoutePost($this->userSession, new RoutesSqlite($this->pdo, (int)$matches[1]));
        }
        if (preg_match('|^/api/calendars$|', $value, $matches) === 1) {
            return new CalendarPost(
                $this->userSession,
                new CalendarsSqlite($this->pdo)
            );
        }
        if (preg_match('|^/api/publishers$|', $value, $matches) === 1) {
            return new PublisherPost(
                $this->userSession,
                new PublishersSqlite($this->pdo),
                $this->config
            );
        }

        return $this;
    }
}
