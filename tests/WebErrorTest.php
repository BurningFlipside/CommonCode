<?php
require_once('Autoload.php');
class WebErrorTest extends PHPUnit\Framework\TestCase
{
    public function testBasic()
    {
        $app = new \Flipside\Http\Rest\RestAPI();
        $error = new \Flipside\Http\WebErrorHandler();
        $uri = \Slim\Http\Uri::createFromString('http://example.org');
        $headers = new \Slim\Http\Headers();
        $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
        $request = new \Slim\Http\Request('GET', $uri, $headers, array(), array(), $body);
        $response = new \Slim\Http\Response();
        $response = $error($request, $response, new \Exception());
        $this->assertNotNull($response);
        $this->assertEquals(500, $response->getStatusCode());

        $e = new \Exception('', \Flipside\Http\Rest\ACCESS_DENIED);
        $response = $error($request, $response, $e);
        $this->assertNotNull($response);
        $this->assertEquals(401, $response->getStatusCode());
    }
}
