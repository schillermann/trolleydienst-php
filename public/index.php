<?php
require __DIR__ . '/../vendor/autoload.php';

use App\AppConfig;
use App\Pages\LoginPage;
use App\Pages\LogoutPage;
use App\Pages\UserListPage;
use App\UserPool;
use PhpPages\App;
use PhpPages\Page\LayoutPage;
use PhpPages\Page\PageWithRoutes;
use PhpPages\Page\PageWithType;
use PhpPages\Page\SessionPage;
use PhpPages\Page\TextPage;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;
use PhpPages\Session\NativeSession;
use PhpPages\Template\SimpleTemplate;

$appConfig = new AppConfig();
$userPool = new UserPool(
    new \PDO('sqlite:./../database.sqlite')
);

$session = new NativeSession();
$session->start();

(new App(
    new SessionPage(
        new PageWithType(
            (new LayoutPage(
                new SimpleTemplate('../templates/layout.php'),
                [
                    'config' => $appConfig
                ]
            ))
                ->withPage(
                    (new PageWithRoutes(
                        new TextPage('Not Found'),
                    ))
                        ->withRoute(
                            '/',
                            new UserListPage(
                                new SimpleTemplate('../templates/pages/user-list.php'),
                                $userPool
                            )
                        )
                        ->withRoute(
                            '/login',
                            new LoginPage(
                                new SimpleTemplate('../templates/pages/login.php'),
                                $userPool,
                                $session
                            )
                        )
                        ->withRoute(
                            '/user-list',
                            new UserListPage(
                                new SimpleTemplate('../templates/pages/user-list.php'),
                                $userPool
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