<?php

namespace Http;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController {
    protected \Twig\Environment $twig;
    protected $conn;
    public function __construct()
    {
        // initiate DB connection
        $this->conn = \Services\DatabaseConnector::getConnection();

        // bootstrap Twig
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);
    }
}?>