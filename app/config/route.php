<?php

/*
** Класс маршрутизации
** localhost/account
** localhost/account/login
** localhost/account/register
** localhost/account/settings
** localhost/account/logout
*/

class Routing {
    public static function buildRoute() {
        /*Контроллер и action по умолчанию*/
        $controllerName = "IndexController";
        $modelName = "IndexModel";
        $action = "index";

        $route = explode("/", $_SERVER['REQUEST_URI']);

        /*Определяем контроллер*/
		if($route[1] != '') {
			$controllerName = ucfirst($route[1]. "Controller");
			$modelName = ucfirst($route[1]. "Model");
        }
        
        if (!file_exists(CONTROLLER_PATH . $controllerName . ".php")) {
            header("Location: /public/404.html");
            return;
        }

        require_once CONTROLLER_PATH . $controllerName . ".php"; //IndexController.php
        require_once MODEL_PATH . $modelName . ".php"; //IndexModel.php
        
        if(isset($route[2]) && $route[2] !='') {
			$action = $route[2];
        }
        
        $controller = new $controllerName();
        if (!method_exists($controller, $action)) {
            header("Location: /public/404.html");
            return;
        }
        $controller->$action();
    }
}