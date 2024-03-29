<?php
// Justin PHP Framework
// It's a portable framework for PHP 8.0+, powered by open source community.
// Licensed under the MIT License. (https://ncurl.xyz/s/2ltII6Ang)
// (c) 2022 Star Inc. (https://starinc.xyz)

require_once __DIR__ . '/../../Models/User.php';
require_once __DIR__ . '/../MiddlewareInterface.php';
require_once __DIR__ . '/../../Controllers/ControllerInterface.php';

class CORS implements MiddlewareInterface
{
    public const METHOD_GET = "GET";
    public const METHOD_POST = "POST";
    public const METHOD_PUT = "PUT";
    public const METHOD_PATCH = "PATCH";
    public const METHOD_DELETE = "DELETE";
    public const METHOD_OPTIONS = "OPTIONS";

    public static function trigger(ControllerInterface $controller): void
    {
        assert($controller instanceof AllowCORS, new AssertionError("The controller is not allowed CORS."));
        if (!$controller->getConfig()->get("CORS", false)) return;
        self::rewrite($controller);
        if ($controller->getRequest()->getMethod() === self::METHOD_OPTIONS) {
            $controller->getResponse()->setStatus(204)->send(true);
        }
    }

    public static function rewrite(AllowCORS $controller)
    {
        $controller->getResponse()
            ->setHeader("Access-Control-Allow-Origin", $controller->getAllowOrigin())
            ->setHeader("Access-Control-Allow-Methods", implode(", ", $controller->getAllowMethods()))
            ->setHeader("Access-Control-Allow-Headers", implode(", ", $controller->getAllowHeaders()));
        if ($controller->getAllowCredentials()) {
            $controller->getResponse()
                ->setHeader("Access-Control-Allow-Credentials", "true");
        }
    }
}
