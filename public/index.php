<?php

use App\Api\DeletePage;
use App\Api\GetPage;
use App\Api\PostPage;
use App\Api\PutPage;
use App\Api\UnauthorizedPage;
use App\Config;
use App\UserSession;
use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\RequestInterface;
use PhpPages\Response\NativeResponse;
use PhpPages\Session\NativeSession;
use PhpPages\SessionInterface;

require __DIR__ . '/../vendor/autoload.php';

(new App(
    new class () implements PageInterface {
        private \PDO $pdo;
        private SessionInterface $session;
        private UserSession $userSession;

        public function __construct(private string $httpMethod = '')
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
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        public function withMetadata(string $name, string $value): PageInterface
        {
            if (PageInterface::METADATA_METHOD === $name) {
                $this->session->start();
                if (!$this->userSession->active()) {
                    return new UnauthorizedPage();
                }
                $config = new Config();

                switch ($value) {
                    case RequestInterface::METHOD_GET:
                        return new GetPage($this->pdo, $this->userSession, $this->session, $config);
                    case RequestInterface::METHOD_POST:
                        return new PostPage($this->pdo, $this->userSession, $config);
                    case RequestInterface::METHOD_PUT:
                        return new PutPage($this->pdo, $this->userSession, $config);
                    case RequestInterface::METHOD_DELETE:
                        return new DeletePage($this->pdo, $this->userSession, $config);
                }
                return new self($value);
            }

            return $this;
        }
    }
))
  ->start(
      new NativeRequest(),
      new NativeResponse()
  );
