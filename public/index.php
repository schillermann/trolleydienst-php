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
use App\ShiftHistoryPage;
use App\ShiftPage;
use App\ShiftTypePage;
use App\SubmitReportPage;
use App\SystemHistoryPage;
use App\UpdatePage;
use App\UploadFilePage;
use App\UserDetailsPage;
use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\Page\TextPage;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

require __DIR__ . '/../vendor/autoload.php';

(new App(
    new class implements PageInterface {
        public function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        public function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::PATH) {
                return $this;
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
                default:
                    return new TextPage('Page not found');
            }
        }
    }
))
    ->start(
        new NativeRequest(),
        new NativeResponse()
    );