<?php

use App\AddPublisherPage;
use App\AddShiftPage;
use App\AddShiftTypePage;
use App\AdjustPublisherPage;
use App\AdjustShiftPage;
use App\AdjustShiftTypePage;
use App\ChangePublisherPassword;
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
use App\Shift\Api\CreateShiftsCommand;
use App\Shift\Api\PublishersEnabledQuery;
use App\Shift\Api\RegisterPublisherForShiftCommand;
use App\Shift\Api\ShiftCreatedQuery;
use App\Shift\Api\ShiftPositionsCreatedQuery;
use App\Shift\Api\ShiftsCreatedQuery;
use App\Shift\Api\WithdrawShiftApplicationCommand;
use App\Shift\Publishers;
use App\Shift\ShiftCalendar;
use App\Shift\ShiftPage;
use App\ShiftHistoryPage;
use App\ShiftTypePage;
use App\SubmitReportPage;
use App\SystemHistoryPage;
use App\UpdatePage;
use App\UploadFilePage;
use App\UserDetailsPage;
use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

require __DIR__ . '/../vendor/autoload.php';

(new App(
    new class implements PageInterface {

        private string $httpMethod;
        private \PDO $pdo;

        public function __construct(string $httpMethod = '')
        {
            $this->httpMethod = $httpMethod;

            $this->pdo = new \PDO('sqlite:./../database.sqlite');
            $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function viaOutput(OutputInterface $output): OutputInterface
        {
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

            if ($this->httpMethod === 'POST') {
                switch($value) {
                    case '/api/shift/register-publisher-for-shift':
                        return new RegisterPublisherForShiftCommand(
                            new ShiftCalendar($this->pdo)
                        );
                    case '/api/shift/withdraw-shift-application':
                        return new WithdrawShiftApplicationCommand(
                            new ShiftCalendar($this->pdo)
                        );
                    case '/api/shift/create-shifts':
                        return new CreateShiftsCommand(
                            new ShiftCalendar($this->pdo)
                        );
                }
            }

            if ($this->httpMethod === 'GET') {
                switch($value) {
                    case '/api/shift/shifts-created':
                        return new ShiftsCreatedQuery(
                            new ShiftCalendar($this->pdo)
                        );
                    case '/api/shift/publishers-enabled':
                        return new PublishersEnabledQuery(
                            new Publishers($this->pdo)
                        );
                    case '/api/shift/shift-created':
                        return new ShiftCreatedQuery($this->pdo);
                }
            }

            switch($value) {
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