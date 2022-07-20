<?php
require __DIR__ . '/../vendor/autoload.php';

use App\AppConfig;
use App\Pages\LoginPage;
use App\Pages\LogoutPage;
use App\Pages\NotFoundPage;
use App\Pages\PublishersPage;
use App\Pages\UserEditPage;
use App\PublisherPool;
use App\PublisherPoolInterface;
use PhpPages\App;
use PhpPages\Language\SimpleLanguage;
use PhpPages\Page\LayoutPage;
use PhpPages\Page\PageWithRoutes;
use PhpPages\Page\PageWithType;
use PhpPages\Page\RedirectPage;
use PhpPages\Page\SessionPage;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;
use PhpPages\Session\NativeSession;
use PhpPages\Template\SimpleTemplate;

$appConfig = new AppConfig();
$language = new SimpleLanguage('../language/de.php');
$publisherPool = new PublisherPool(
    new \PDO('sqlite:./../database.sqlite')
);

$session = new NativeSession();
$session->start();

(new App(
    new SessionPage(
        new PageWithType(
            (new LayoutPage(
                new SimpleTemplate('../templates/layout.php')
            ))
                ->withParam('config', $appConfig)
                ->withPage(
                    (new PageWithRoutes(
                        new NotFoundPage(),
                    ))
                        ->withRoute(
                            '/',
                            new RedirectPage('/publishers')
                        )
                        ->withRoute(
                            '/login',
                            new LoginPage(
                                new SimpleTemplate('../templates/pages/login.php'),
                                $language,
                                $publisherPool,
                                $session
                            )
                        )
                        ->withRoute(
                            '/publishers',
                            new PublishersPage(
                                new SimpleTemplate('../templates/pages/publishers.php'),
                                $language,
                                $publisherPool
                            )
                        )
                        ->withRoute(
                            '/user-edit',
                            new UserEditPage(
                                new SimpleTemplate('../templates/pages/user-edit.php'),
                                $language,
                                $publisherPool
                            )
                        )
                        ->withRoute(
                            '/logout',
                            new LogoutPage($session)
                        )
                ),
            'text/html;charset=UTF-8'
        ),
        $session,
        '/login'
    )
))
    ->start(
        new NativeRequest(),
        new NativeResponse()
    );