<?php

use App\Middleware\CsrfMiddleware;
use App\Middleware\InvalidCsrfException;
use App\Middleware\NoCsrfException;
use PHPUnit\Framework\TestCase;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class MiddlewareTest extends TestCase 
{
    private function makeMiddleware(&$session = [])
    {
        return new CsrfMiddleware($session);
    }

    private function makeRequest($method = 'GET', ?array $params = null)
    {
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getMethod')->willReturn($method);
        $request->method('getParsedBody')->willReturn($params);
        return $request;
    }

    private function makeResponse()
    {
        return $this->getMockBuilder(ResponseInterface::class)->getMock();
    }

    private function makeHandler()
    {
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $handler->method('handle')->willReturn($this->makeResponse());
        return $handler;
    }

    /**
     * @test method GET
     */
    public function testGetPass()
    {
        $this->markTestIncomplete('C\'est Testé');

        $middleware = $this->makeMiddleware();
        $request = $this->makeRequest('GET');
        $handler = $this->makeHandler();
        //Methode process appele une fois
        $handler->expects($this->once())->method('handle');
        //$middleware->process($request, $handler);
    }

    /**
     * @test method POST
     */
    public function testPreventPost()
    {
        $this->markTestIncomplete('C\'est Testé');

        $middleware = $this->makeMiddleware();
        $request = $this->makeRequest('POST');
        $handler = $this->makeHandler();
        $handler->expects($this->never())->method('handle');
        //Lance une exception
        $this->expectException(NoCsrfException::class);
        //$middleware->process($request, $handler);
    }

    /**
     * @test avec token valide
     */
    public function testPostWithValidToken()
    {
        $this->markTestIncomplete('C\'est Testé');

        $middleware = $this->makeMiddleware();
        $token = $middleware->generateToken();
        $request = $this->makeRequest('POST', ['_csrf' => $token]);
        $handler = $this->makeHandler();
        //Methode process appele une fois
        $handler->expects($this->once())->method('handle')->willReturn($this->makeResponse());
        //$middleware->process($request, $handler);
    }

    /**
     * @test avec token invalide
     */
    public function testPostWithInvalidToken()
    {
        $this->markTestIncomplete('C\'est Testé');

        $middleware = $this->makeMiddleware();
        $request = $this->makeRequest('POST', ['_csrf' => 'aze']);
        $handler = $this->makeHandler();
        //Methode process appele une fois
        $handler->expects($this->never())->method('handle');
        //Lance une exception
        $this->expectException(InvalidCsrfException::class);
        //$middleware->process($request, $handler);
    }
}