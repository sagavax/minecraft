<?php
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private $router;

    protected function setUp(): void
    {
        // Suppress output and warnings from router.php when included
        $_SERVER['REQUEST_URI'] = '/no-route';
        $prevHandler = set_error_handler(function () {});
        ob_start();
        require_once __DIR__ . '/../router.php';
        ob_end_clean();
        restore_error_handler();

        // Create fresh instance for testing
        $this->router = new Router();
    }

    public function testRouteExecutesHandler()
    {
        $handlerFile = __DIR__ . '/dummy_handler.php';
        $this->router->addRoute('/test', $handlerFile);

        ob_start();
        $this->router->route('/test');
        $output = ob_get_clean();

        $this->assertEquals('handled', trim($output));
    }
}
