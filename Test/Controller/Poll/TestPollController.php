<?php

namespace Test\Controller\Poll;

require_once join(DIRECTORY_SEPARATOR,[ __DIR__, '..', '..', '..', 'AutoLoad.php' ]);
use PHPUnit\Framework\TestCase;
use Controller\Poll\PollController;
use Helper\Route\RouteHelper;
use Contract\Poll\IPollDA;
use Contract\User\IUserSession;
use Contract\Render\IRenderer;
use Contract\Redirection\IRedirector;
use Contract\Request\IRequestInfoProvider;

class TestPollController extends TestCase {
    /**
     * @test
     */
    public function TestPollAddRoute() : void {
        $routeHelper = new RouteHelper();
        $route = $routeHelper->GetRoute("PollAdd");

        $this->assertEquals("/poll/add", $route);
    }

    private $redirectRoute = "route";
    private $renderFilePath = "";
    private $renderArgs;
    /**
     * @test
     */
    public function TestRedirectIfNotLogged() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(false);
        $renderer = $this->createMock(IRenderer::class);
        $redirector = $this->createMock(IRedirector::class);
        $redirector->method("Redirect")->will($this->returnCallback(function($route) { $this->redirectRoute = $route; return; }));
        $rip = $this->createMock(IRequestInfoProvider::class);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);

        $controller->Add();

        $routeHelper = new RouteHelper();
        $homeRoute = $routeHelper->GetRoute("HomeDisplay");
        $this->assertEquals($homeRoute, $this->redirectRoute);
    }

    /**
     * @test
     */
    public function TestRedirectIfLoggedAndNotGetOrPostRequest() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $redirector = $this->createMock(IRedirector::class);
        $redirector->method("Redirect")->will($this->returnCallback(function($route) { $this->redirectRoute = $route; return; }));
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(false);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $routeHelper = new RouteHelper();
        $homeRoute = $routeHelper->GetRoute("HomeDisplay");
        $this->assertEquals($homeRoute, $this->redirectRoute);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoAccessesToPollAddPage() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(true);
        $rip->method("IsPost")->willReturn(false);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("", $this->renderArgs["question"]);
        $this->assertEquals("7", $this->renderArgs["duration"]);
        $this->assertEquals("", $this->renderArgs["answer_1"]);
        $this->assertEquals("", $this->renderArgs["answer_2"]);
        $this->assertEquals("", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoSubmitsPollWithoutQuestion() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(true);
        $rip->method("GetSubmitData")->willReturn(
            [ 
                "question" => ""
                , "duration" => 15
                , "answer_1" => "Ma réponse 1"
                , "answer_2" => "Ma réponse 2"
                , "answer_3" => ""
                , "answer_4" => ""
                , "answer_5" => ""
             ]);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("", $this->renderArgs["question"]);
        $this->assertEquals("15", $this->renderArgs["duration"]);
        $this->assertEquals("Ma réponse 1", $this->renderArgs["answer_1"]);
        $this->assertEquals("Ma réponse 2", $this->renderArgs["answer_2"]);
        $this->assertEquals("", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([ "La saisie de la question est obligatoire." ], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoSubmitsPollWithoutDuration() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(true);
        $rip->method("GetSubmitData")->willReturn(
            [ 
                "answer_1" => "Ma réponse 1"
                , "answer_2" => "Ma réponse 2"
                , "answer_3" => ""
                , "answer_4" => ""
                , "answer_5" => ""
             ]);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("", $this->renderArgs["question"]);
        $this->assertEquals("7", $this->renderArgs["duration"]);
        $this->assertEquals("Ma réponse 1", $this->renderArgs["answer_1"]);
        $this->assertEquals("Ma réponse 2", $this->renderArgs["answer_2"]);
        $this->assertEquals("", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([ "La saisie de la question est obligatoire." ], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoSubmitsPollWithoutAnswer() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(true);
        $rip->method("GetSubmitData")->willReturn(
            [ 
                "question" => "Ma question"
                , "duration" => 30
                , "answer_1" => ""
                , "answer_2" => ""
                , "answer_3" => ""
                , "answer_4" => ""
                , "answer_5" => ""
             ]);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("Ma question", $this->renderArgs["question"]);
        $this->assertEquals("30", $this->renderArgs["duration"]);
        $this->assertEquals("", $this->renderArgs["answer_1"]);
        $this->assertEquals("", $this->renderArgs["answer_2"]);
        $this->assertEquals("", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([ "La saisie d'au moins deux réponses est obligatoire." ], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([ "La saisie d'au moins deux réponses est obligatoire." ], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoSubmitsPollWithOnlyAnswer1() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(true);
        $rip->method("GetSubmitData")->willReturn(
            [ 
                "question" => "Ma question"
                , "duration" => 1
                , "answer_1" => "Ma réponse 1"
                , "answer_2" => ""
                , "answer_3" => ""
                , "answer_4" => ""
                , "answer_5" => ""
             ]);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("Ma question", $this->renderArgs["question"]);
        $this->assertEquals("1", $this->renderArgs["duration"]);
        $this->assertEquals("Ma réponse 1", $this->renderArgs["answer_1"]);
        $this->assertEquals("", $this->renderArgs["answer_2"]);
        $this->assertEquals("", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([ "La saisie d'au moins deux réponses est obligatoire." ], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoSubmitsPollWithOnlyAnswer3() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(true);
        $rip->method("GetSubmitData")->willReturn(
            [ 
                "question" => "Ma question"
                , "duration" => 1
                , "answer_1" => ""
                , "answer_2" => ""
                , "answer_3" => "Ma réponse 3"
                , "answer_4" => ""
                , "answer_5" => ""
             ]);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("Ma question", $this->renderArgs["question"]);
        $this->assertEquals("1", $this->renderArgs["duration"]);
        $this->assertEquals("", $this->renderArgs["answer_1"]);
        $this->assertEquals("", $this->renderArgs["answer_2"]);
        $this->assertEquals("Ma réponse 3", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([ "La saisie d'au moins deux réponses est obligatoire." ], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoSubmitsPollWithTooLongQuestion() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(true);
        $rip->method("GetSubmitData")->willReturn(
            [ 
                "question" => "rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr"
                , "duration" => 1
                , "answer_1" => "Ma réponse 1"
                , "answer_2" => ""
                , "answer_3" => "Ma réponse 3"
                , "answer_4" => ""
                , "answer_5" => ""
             ]);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr", $this->renderArgs["question"]);
        $this->assertEquals("1", $this->renderArgs["duration"]);
        $this->assertEquals("Ma réponse 1", $this->renderArgs["answer_1"]);
        $this->assertEquals("", $this->renderArgs["answer_2"]);
        $this->assertEquals("Ma réponse 3", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([ "La question est trop longue (100 caractères max)." ], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }

    /**
     * @test
     */
    public function TestLoggedUserWhoSubmitsPollWithTooLongAnswer() : void {
        $da = $this->createMock(IPollDA::class);
        $session = $this->createMock(IUserSession::class);
        $session->method("IsLogin")->willReturn(true);
        $renderer = $this->createMock(IRenderer::class);
        $renderer->method("Render")->will($this->returnCallback(function($filePath, $args) { $this->renderFilePath = $filePath; $this->renderArgs = $args; return ""; }));
        $redirector = $this->createMock(IRedirector::class);
        $rip = $this->createMock(IRequestInfoProvider::class);
        $rip->method("IsGet")->willReturn(false);
        $rip->method("IsPost")->willReturn(true);
        $rip->method("GetSubmitData")->willReturn(
            [ 
                "question" => "Ma question"
                , "duration" => 15
                , "answer_1" => ""
                , "answer_2" => ""
                , "answer_3" => "rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr"
                , "answer_4" => ""
                , "answer_5" => ""
             ]);

        $controller = new PollController($da, $session, $renderer, $redirector, $rip);
        $controller->Add();

        $this->assertEquals(join(DIRECTORY_SEPARATOR,[ "Poll", "Add.twig" ]), $this->renderFilePath);
        $this->assertEquals("Ma question", $this->renderArgs["question"]);
        $this->assertEquals("15", $this->renderArgs["duration"]);
        $this->assertEquals("", $this->renderArgs["answer_1"]);
        $this->assertEquals("", $this->renderArgs["answer_2"]);
        $this->assertEquals("rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr", $this->renderArgs["answer_3"]);
        $this->assertEquals("", $this->renderArgs["answer_4"]);
        $this->assertEquals("", $this->renderArgs["answer_5"]);
        $this->assertEquals([], $this->renderArgs["errors"]["question"]);
        $this->assertEquals([ "La saisie d'au moins deux réponses est obligatoire." ], $this->renderArgs["errors"]["answer_1"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_2"]);
        $this->assertEquals([ "La réponse est trop longue (100 caractères max)." ], $this->renderArgs["errors"]["answer_3"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_4"]);
        $this->assertEquals([], $this->renderArgs["errors"]["answer_5"]);
    }
}