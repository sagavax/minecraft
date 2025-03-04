<?php

class Router {
    private $routes = [];

    // Add a route to the router
    public function addRoute($url, $handler) {
        $this->routes[$url] = $handler;
    }

    // Match the current request to a route and execute the associated handler
    public function route($url) {
        if (isset($this->routes[$url])) {
            // Match found, execute the handler
            $handler = $this->routes[$url];
            $this->executeHandler($handler);
        } else {
            // No match found
            $this->notFound();
        }
    }

    // Execute the handler (include the corresponding file in this case)
    private function executeHandler($handler) {
        include $handler;
    }

    // Handle 404 Not Found
    private function notFound() {
        http_response_code(404);
        echo "404 Not Found";
    }
}

// Create a new router instance
$router = new Router();

// Add routes for each file
$router->addRoute('/videos', 'videos.php');
$router->addRoute('/notes', 'notes.php');
$router->addRoute('/vanilla', 'vanilla.php');
$router->addRoute('/tasks', 'tasks.php');
$router->addRoute('/dashboard', 'dashboard.php');
$router->addRoute('/modpacks', 'modpacks.php');
$router->addRoute('/logout', 'logout.php');

// Get the current URL
$currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request based on the current URL
$router->route($currentUrl);
