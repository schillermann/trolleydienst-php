<?php

use App\AddPublisherPage;
use App\AddShiftPage;
use App\AddShiftTypePage;
use App\AdjustPublisherPage;
use App\AdjustShiftPage;
use App\AdjustShiftTypePage;
use App\Api\CalendarGet;
use App\Api\CalendarRouteGet;
use App\Api\CalendarRoutesGet;
use App\Api\MeQuery;
use App\Api\PublisherGet;
use App\Api\PublishersGet;
use App\Api\ShiftApplicationsGet;
use App\Api\ShiftsPost;
use App\Api\ShiftPositionPublisherGet;
use App\Api\ShiftPositionPublishersGet;
use App\Api\SlotDelete;
use App\Api\SlotsPost;
use App\ChangePublisherPassword;
use App\Database\CalendarRoutesSqlite;
use App\Database\CalendarsSqlite;
use App\Database\PublishersSqlite;
use App\Database\ShiftSlotsSqlite;
use App\Database\SlotsSqlite;
use App\EditFilePage;
use App\EmailSettingsPage;
use App\EmailTemplatesPage;
use App\FileViewPage;
use App\InfoPage;
use App\InstallPage;
use App\LoginHistoryPage;
use App\LoginPage;
use App\NewsletterPage;
use App\PublisherProfilePage;
use App\PublishersPage;
use App\ReportPage;
use App\ResetPasswordPage;
use App\Shift\ShiftPage;
use App\ShiftHistoryPage;
use App\ShiftTypePage;
use App\SubmitReportPage;
use App\SystemHistoryPage;
use App\UpdatePage;
use App\UploadFilePage;
use App\UserDetailsPage;
use App\UserSession;
use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;
use PhpPages\Session\NativeSession;
use PhpPages\SessionInterface;

require __DIR__ . '/../vendor/autoload.php';

(new App(
  new class() implements PageInterface
  {
    private string $httpMethod;
    private \PDO $pdo;
    private SessionInterface $session;

    public function __construct(string $httpMethod = '')
    {
      $this->httpMethod = $httpMethod;

      $this->pdo = new \PDO('sqlite:./../database.sqlite');
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

      $this->session = new NativeSession();
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
      include('../config.php');
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
      if ($name === PageInterface::METHOD) {
        return new self($value);
      }

      if ($name !== PageInterface::PATH) {
        return $this;
      }

      $this->session->start();

      if ($this->httpMethod === 'POST') {
        if (preg_match('|^/api/calendars/([0-9]+)/shifts$|', $value, $matches) === 1) {
          return new ShiftsPost(
            new CalendarRoutesSqlite($this->pdo, (int)$matches[1])
          );
        }
        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)/shifts/([0-9]+)/slots$|', $value, $matches) === 1) {
          return new SlotsPost(
            new SlotsSqlite($this->pdo),
            new CalendarRoutesSqlite($this->pdo, (int)$matches[1]),
            new PublishersSqlite($this->pdo),
            (int)$matches[2],
            (int)$matches[3]
          );
        }
      }

      if ($this->httpMethod === 'GET') {
        if (preg_match('|^/api/shifts/([0-9]+)/applications$|', $value, $matches) === 1) {
          return new ShiftApplicationsGet(
            new ShiftSlotsSqlite($this->pdo),
            (int)$matches[1]
          );
        }

        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)$|', $value, $matches) === 1) {
          return new CalendarRouteGet(
            new CalendarRoutesSqlite($this->pdo, (int)$matches[1]),
            (int)$matches[2]
          );
        }

        if (preg_match('|^/api/calendars/([0-9]+)/routes$|', $value, $matches) === 1) {
          return new CalendarRoutesGet(
            new CalendarsSqlite($this->pdo),
            new CalendarRoutesSqlite($this->pdo, (int)$matches[1]),
            new SlotsSqlite($this->pdo),
            (int)$matches[1]
          );
        }

        if (preg_match('|^/api/calendars/([0-9]+)$|', $value, $matches) === 1) {
          return new CalendarGet(
            new CalendarsSqlite($this->pdo),
            (int)$matches[1]
          );
        }

        if ('/api/publishers' === $value) {
          return new PublishersGet(new PublishersSqlite($this->pdo));
        }

        if (preg_match('|^/api/shifts/([0-9]+)/positions/([0-9]+)/publishers/([0-9]+)$|', $value, $matches) === 1) {
          return new ShiftPositionPublisherGet(
            new SlotsSqlite($this->pdo),
            new PublishersSqlite($this->pdo),
            (int)$matches[1],
            (int)$matches[2],
            (int)$matches[3],
          );
        }

        if (preg_match('|^/api/shifts/([0-9]+)/positions/([0-9]+)/publishers$|', $value, $matches) === 1) {
          return new ShiftPositionPublishersGet(
            new SlotsSqlite($this->pdo),
            new PublishersSqlite($this->pdo),
            (int)$matches[1],
            (int)$matches[2],
          );
        }

        if (preg_match('|^/api/publishers/([0-9]+)$|', $value, $matches) === 1) {
          return new PublisherGet(
            new PublishersSqlite($this->pdo),
            (int)$matches[1]
          );
        }

        switch ($value) {
          case '/api/me':
            return new MeQuery(new UserSession($this->session));
        }
      }

      if ($this->httpMethod === 'DELETE') {
        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)/shifts/([0-9]+)/publishers/([0-9]+)$|', $value, $matches) === 1) {
          return new SlotDelete(
            new SlotsSqlite($this->pdo),
            (int)$matches[2],
            (int)$matches[3],
            (int)$matches[4]
          );
        }
      }

      switch ($value) {
        case '/':
          return new LoginPage();
        case '/shift':
          return new ShiftPage();
        case '/add-shift':
          return new AddShiftPage();
        case '/adjust-shift':
          return new AdjustShiftPage();
        case '/user-details':
          return new UserDetailsPage();
        case '/report':
          return new ReportPage();
        case '/submit-report':
          return new SubmitReportPage();
        case '/publisher-profile':
          return new PublisherProfilePage();
        case '/change-publisher-password':
          return new ChangePublisherPassword();
        case '/publishers':
          return new PublishersPage();
        case '/add-publisher':
          return new AddPublisherPage();
        case '/adjust-publisher':
          return new AdjustPublisherPage();
        case '/newsletter':
          return new NewsletterPage();
        case '/info':
          return new InfoPage();
        case '/upload-file':
          return new UploadFilePage();
        case '/file-view':
          return new FileViewPage();
        case '/edit-file':
          return new EditFilePage();
        case '/reset-password':
          return new ResetPasswordPage();
        case '/shift-type':
          return new ShiftTypePage();
        case '/adjust-shift-type':
          return new AdjustShiftTypePage();
        case '/add-shift-type':
          return new AddShiftTypePage();
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

      return $this;
    }
  }
))
  ->start(
    new NativeRequest(),
    new NativeResponse()
  );
