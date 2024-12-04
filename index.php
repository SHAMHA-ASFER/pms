<?php
require_once __DIR__ . "/core/Request.php";
require_once __DIR__ . "/core/Router.php";
require_once __DIR__ . "/core/Control.php";
require_once __DIR__ . "/Controls/User.php";
require_once __DIR__ . "/Controls/AnalyzerController.php";
require_once __DIR__ . "/Controls/DeveloperController.php";
require_once __DIR__ . "/Controls/PMController.php";
require_once __DIR__ . "/Controls/PMOController.php";
require_once __DIR__ . "/Controls/QAController.php";

$request = new Request();
$router = new Router();

// GET METHOD REQUESTS
$router->addRoute("GET","/login",[UserController::class,"login"]);
$router->addRoute("GET","/logout",[UserController::class, "logout"]);
$router->addRoute("GET","/signup",[UserController::class,"signup"]);
$router->addRoute("GET","/analyzer",[AnalyzerController::class, "index"]);
$router->addRoute("GET","/dev",[DeveloperController::class, "index"]);
$router->addRoute("GET","/manager",[PMController::class, "index"]);
$router->addRoute("GET","/qa",[QAController::class, "index"]);
$router->addRoute("GET","/pmo",[PMOController::class,"index"]);
$router->addRoute("GET","/qa/home",[QAController::class,"home"]);
$router->addRoute("GET","/qa/validate",[QAController::class,"validateFile"]);
$router->addRoute("GET","/qa/update",[QAController::class,"updateTaskState"]);
$router->addRoute("GET", "/manager/home",[PMController ::class,"home"]);
$router->addRoute("GET","/manager/project",[PMController:: class,"manageProject"]);
$router->addRoute("GET","/manager/task",[PMController:: class,"manageTask"]);
$router->addRoute("GET","/manager/members",[PMController::class,"manageMembers"]);
$router->addRoute("GET","/analyzer/home",[AnalyzerController::class,"home"]);
$router->addRoute("GET","/analyzer/create",[AnalyzerController::class,"createDocument"]);
$router->addRoute("GET","/analyzer/update",[AnalyzerController::class,"updateContent"]);
$router->addRoute("GET","/dev/home",[DeveloperController::class,"home"]);
$router->addRoute("GET","/dev/view",[DeveloperController::class,"viewTask"]);
$router->addRoute("GET","/dev/create",[DeveloperController::class, "createFile"]);
$router->addRoute("GET","/dev/update",[DeveloperController::class, "updateFile"]);





// POST METHOD REQUESTS

$router->addRoute("POST","/login",[UserController::class,"login"]);
$router->addRoute("POST","/signup",[UserController::class,"signup"]);


include_once __DIR__ ."/header.php";
$router->resolveRoute($request);
include_once __DIR__ ."/footer.php";