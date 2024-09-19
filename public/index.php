<?php

use App\AddPublisherPage;
use App\Api\CalendarDelete;
use App\Api\CalendarGet;
use App\Api\CalendarPut;
use App\Api\CalendarsGet;
use App\Api\CalendarPost;
use App\Api\RouteGet;
use App\Api\MeGet;
use App\Api\PublisherDelete;
use App\Api\PublisherGet;
use App\Api\PublisherPost;
use App\Api\PublisherPut;
use App\Api\PublishersGet;
use App\Api\RouteDelete;
use App\Api\RoutePost;
use App\Api\RoutePut;
use App\Api\RoutesGet;
use App\Api\ShiftApplicationsGet;
use App\Api\ShiftsPost;
use App\Api\ShiftPositionPublisherGet;
use App\Api\ShiftPositionPublishersGet;
use App\Api\SlotDelete;
use App\Api\SlotsPost;
use App\ChangePublisherPassword;
use App\Database\RoutesSqlite;
use App\Database\CalendarsSqlite;
use App\Database\PublishersSqlite;
use App\Database\ShiftSlotsSqlite;
use App\Database\SlotsSqlite;
use App\EditFilePage;
use App\EditPublisherPage;
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
    private UserSession $userSession;

    public function __construct(string $httpMethod = '', bool $authenticated = false)
    {
      $this->httpMethod = $httpMethod;

      if (file_exists('./../database.sqlite')) {
        $this->pdo = new \PDO('sqlite:./../database.sqlite');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      }

      $this->session = new NativeSession();
      $this->userSession = new UserSession($this->session);
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
      if (!$this->userSession->active()) {
        return $output->withMetadata(
          PageInterface::STATUS,
          PageInterface::STATUS_401_UNAUTHORIZED
        );
      }

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

      switch ($value) {
        case '/':
          return new LoginPage();
        case '/shift':
          return new ShiftPage();
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
        case '/edit-publisher':
          return new EditPublisherPage();
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

      if (!$this->userSession->active() && $value != '/') {
        return new self($this->httpMethod, true);
      }

      if ($this->httpMethod === 'POST') {
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
            DEMO,
          );
        }
      }

      if ($this->httpMethod === 'GET') {
        if ('/api/me' === $value) {
          return new MeGet($this->userSession, $this->session);
        }

        if (preg_match('|^/api/shifts/([0-9]+)/applications$|', $value, $matches) === 1) {
          return new ShiftApplicationsGet(
            new ShiftSlotsSqlite($this->pdo),
            (int)$matches[1]
          );
        }

        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)$|', $value, $matches) === 1) {
          return new RouteGet(
            new RoutesSqlite($this->pdo, (int)$matches[1]),
            (int)$matches[2]
          );
        }

        if (preg_match('|^/api/calendars/([0-9]+)/routes$|', $value, $matches) === 1) {
          return new RoutesGet(
            new CalendarsSqlite($this->pdo),
            new RoutesSqlite($this->pdo, (int)$matches[1]),
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

        if (preg_match('|^/api/calendars$|', $value, $matches) === 1) {
          return new CalendarsGet(new CalendarsSqlite($this->pdo));
        }

        if ('/api/publishers' === $value) {
          return new PublishersGet($this->userSession, new PublishersSqlite($this->pdo));
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
            $this->userSession,
            new PublishersSqlite($this->pdo),
            (int)$matches[1]
          );
        }
      }

      if ($this->httpMethod === 'PUT') {
        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)$|', $value, $matches) === 1) {
          return new RoutePut(
            $this->userSession,
            new RoutesSqlite($this->pdo, (int)$matches[1]),
            (int)$matches[2]
          );
        }

        if (preg_match('|^/api/calendars/([0-9]+)$|', $value, $matches) === 1) {
          return new CalendarPut(
            $this->userSession,
            new CalendarsSqlite($this->pdo),
            (int)$matches[1]
          );
        }

        if (preg_match('|^/api/publishers/([0-9]+)$|', $value, $matches) === 1) {
          return new PublisherPut(new PublishersSqlite($this->pdo), DEMO, (int)$matches[1]);
        }
      }

      if ($this->httpMethod === 'DELETE') {
        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)/shifts/([0-9]+)/publishers/([0-9]+)$|', $value, $matches) === 1) {
          return new SlotDelete(
            $this->userSession,
            new SlotsSqlite($this->pdo),
            (int)$matches[2],
            (int)$matches[3],
            (int)$matches[4]
          );
        }
        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)$|', $value, $matches) === 1) {
          return new RouteDelete(
            $this->userSession,
            new RoutesSqlite($this->pdo, (int)$matches[1]),
            (int)$matches[2]
          );
        }

        if (preg_match('|^/api/calendars/([0-9]+)$|', $value, $matches) === 1) {
          return new CalendarDelete(
            $this->userSession,
            new CalendarsSqlite($this->pdo),
            DEMO,
            (int)$matches[1]
          );
        }

        if (preg_match('|^/api/publishers/([0-9]+)$|', $value, $matches) === 1) {
          return new PublisherDelete(
            $this->userSession,
            new PublishersSqlite($this->pdo),
            DEMO,
            (int)$matches[1]
          );
        }
      }

      return $this;
    }
  }
))
  ->start(
    new NativeRequest(),
    new NativeResponse()
  );
