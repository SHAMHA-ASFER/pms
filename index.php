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
$router->addRoute("GET","/",[UserController::class,"home"]);
$router->addRoute("GET","/about",[UserController::class,"about"]);
$router->addRoute("GET","/contact",[UserController::class, "contact"]);
$router->addRoute("GET","/login",[UserController::class,"login"]);
$router->addRoute("GET","/logout",[UserController::class, "logout"]);
$router->addRoute("GET","/signup",[UserController::class,"signup"]);
$router->addRoute("GET","/dev/dashboard",[DeveloperController::class, "index"]);
$router->addRoute("GET","/manager/dashboard",[PMController::class, "index"]);
$router->addRoute("GET","/manager/handle/analyzer",[PMController::class,"manageAnalyzer"]);
$router->addRoute("GET","/manager/handle/developer",[PMController::class,"manageDeveloper"]);
$router->addRoute("GET","/manager/handle/qa",[PMController::class,"manageQA"]);
$router->addRoute("GET","/manager/handle/task",[PMController::class,"manageTask"]);
$router->addRoute("GET","/manager/handle/doc",[PMController::class,"manageDocument"]);
$router->addRoute("GET","/qa/dashboard",[QAController::class, "index"]);
$router->addRoute("GET","/pmo/dashboard",[PMOController::class,"index"]);
$router->addRoute("GET","/analyzer/dashboard",[AnalyzerController::class,"index"]);

// POST METHOD REQUESTS
$router->addRoute("POST","/login",[UserController::class,"login"]);
$router->addRoute("POST","/signup",[UserController::class,"signup"]);

// DATA FETCH & INPUT USING POST
$router->addRoute("POST","/users/get",[UserController::class,"getUsersByManagerAndRole"]);
$router->addRoute("POST","/project/create" ,[PMController::class,"createProject"]);
$router->addRoute("POST","/doc/create" ,[AnalyzerController::class,"createDocument"]);
$router->addRoute("POST","/doc/update" ,[AnalyzerController::class,"updateDocument"]);
$router->addRoute("POST","/doc/delete" ,[AnalyzerController::class,"deleteDocument"]);
$router->addRoute("POST","/projectanalyzer/add",[PMController::class, "addAnalyzer"]);
$router->addRoute("POST","/projectanalyzer/remove",[PMController::class,"removeAnalyzer"]);
$router->addRoute("POST","/projectdev/add",[PMController::class,"addDeveloper"]);
$router->addRoute("POST","/projectdev/remove",[PMController::class,"removeDeveloper"]);
$router->addRoute("POST","/projectqa/add",[PMController::class,"addQA"]);
$router->addRoute("POST","/projectqa/remove",[PMController::class,"removeQA"]);
$router->addRoute("POST","/task/create",[PMController::class,"createTask"]);
$router->addRoute("POST","/taskmember/add",[PMController::class,"assignMember"]);
$router->addRoute("POST","/taskmember/remove",[PMController::class,"removeMember"]);
$router->addRoute("POST","/document/status",[PMController::class,"updateStatus"]);
$router->addRoute("POST","/project/status/change",[PMController::class, "changeStatus"]);
$router->addRoute("POST", "/project/remove", [PMController::class,"removeProject"]);

include_once __DIR__ ."/header.php";
$router->resolveRoute($request);
include_once __DIR__ ."/footer.php";