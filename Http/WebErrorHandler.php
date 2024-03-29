<?php
namespace Flipside\Http;

require_once('Rest/RestAPI.php');

class WebErrorHandler
{
    public function __invoke($request, $response, $exception)
    {
        if($exception->getCode() === \Flipside\Http\Rest\ACCESS_DENIED)
        {
            $response->getBody()->write('You are not authorized to view this page. The most common cause of this is that you are not logged in to the website. Please log in then try again');
            return $response->withStatus(401);
        }
        else if($exception->getCode() === \Flipside\Http\Rest\INVALID_PARAM)
        {
            return $response->withJson($exception, 400);
        }
        if (php_sapi_name() !== "cli") {
          error_log($exception->__toString());
        }
        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write($exception->__toString());
   }
}
