<?php

namespace Controller\User\Test;

require_once join(DIRECTORY_SEPARATOR,[ __DIR__, '..', '..', '..', 'AutoLoad.php' ]);
use PHPUnit\Framework\TestCase;
use Controller\User\UserController;
use Contract\User\Test\IUserDataProviderMock;
use Contract\User\Test\IUserSessionMock;

class UserControllerTest extends TestCase {
    /**
     * @test Login.feature Scénario: L'identifiant n'est pas renseigné
     */
    public function ErrorWhenLoginIsNotSet() : void {
        $dpMock = new IUserDataProviderMock();
        $sMock = new IUserSessionMock();
        $controller = new UserController($dpMock, $sMock);
        $post = [];
        $loginInfo = $controller->AttemptLogin($post);

        $errors = $loginInfo->GetErrors();
        $this->assertEquals(1, count($errors["login"]));
        $this->assertEquals("La saisie de l'identifiant est obligatoire.", $errors["login"][0]);
    }

    /**
     * @test Login.feature Scénario: Le mot de passe n'est pas renseigné
     */
    public function ErrorWhenPasswordIsNotSet() : void {
        $dpMock = new IUserDataProviderMock();
        $sMock = new IUserSessionMock();
        $controller = new UserController($dpMock, $sMock);
        $post = [];
        $loginInfo = $controller->AttemptLogin($post);

        $errors = $loginInfo->GetErrors();
        $this->assertEquals(1, count($errors["password"]));
        $this->assertEquals("La saisie du mot de passe est obligatoire.", $errors["password"][0]);
    }

    /**
     * @test Login.feature Scénario: L'identifiant n'existe pas
     */
    public function ErrorWhenLoginIsNotExisting() : void {
        $dpMock = new IUserDataProviderMock();
        $dpMock->AddLogins([ "Aslak", "Julien", "Matt" ]);
        $sMock = new IUserSessionMock();
        $controller = new UserController($dpMock, $sMock);
        $post = [ "login" => "Adrien", "password" => "P4ssw0rd" ];
        $loginInfo = $controller->AttemptLogin($post);

        $errors = $loginInfo->GetErrors();
        $this->assertEquals(1, count($errors["login"]));
        $this->assertEquals("L'identifiant n'existe pas.", $errors["login"][0]);
    }

    /**
     * @test Login.feature Scénario: Le mot de passe est incorrect
     */
    public function ErrorWhenPasswordIsNotCorrect() : void {
        $dpMock = new IUserDataProviderMock();
        $dpMock->AddLogins([ "Marc" ]);
        $dpMock->AddHash("Marc", "$2y$10\$zVLew71lBk/wFqrn2t1qb.ZQ5UbA3UD/c.eAxoAE8.mBa80nzY0hi");
        $sMock = new IUserSessionMock();
        $controller = new UserController($dpMock, $sMock);
        $post = [ "login" => "Marc", "password" => "P4ssw0rd" ];
        $loginInfo = $controller->AttemptLogin($post);

        $errors = $loginInfo->GetErrors();
        $this->assertEquals(1, count($errors["password"]));
        $this->assertEquals("Le mot de passe est incorrect.", $errors["password"][0]);
    }

    /**
     * @test Login.feature Scénario: L'identifiant et le mot de passe sont corrects
     */
    public function LoginWhenLoginAndPasswordAreCorrect() : void {
        $dpMock = new IUserDataProviderMock();
        $dpMock->AddLogins([ "Marc" ]);
        $dpMock->AddHash("Marc", "$2y$10\$g6qyxpR4L5H9XsWNdaecGOCUfwEdUoXQdv5y355D8QzkubCZQU4qa");
        $sMock = new IUserSessionMock();
        $controller = new UserController($dpMock, $sMock);
        $post = [ "login" => "Marc", "password" => "P4ssw0rd" ];
        $loginInfo = $controller->AttemptLogin($post);

        $this->assertEquals(true, $sMock->IsLogin());
    }
}