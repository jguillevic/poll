<?php

namespace Contract\User\Test;

use Contract\User\IUserDataProvider;

class IUserDataProviderMock implements IUserDataProvider {
    /**
     * @var array Identifiants
     */
    private $logins;
    /**
     * @var array Paramètres de salage du mot de passe associés aux identifiants.
     */
    private $salts;
    /**
     * @var array Hashs du mot de passe associés aux identifiants.
     */
    private $hashes;

    public function __construct() {
        $this->logins = [];
        $this->salts = [];
        $this->hashes = [];
    }

    /**
     * Ajoute des identifiants.
     * 
     * @param array $logins 
     */
    public function AddLogins(array $logins) {
        foreach ($logins as $login) {
            $this->logins[] = $login;
        }
    }

    public function IsLoginExists(string $login) : bool {
        return in_array($login, $this->logins);
    }

    public function AddHash(string $login, string $hash) : void {
        $this->hashes[$login] = $hash;
    }

    public function GetHash(string $login) : string {
        return $this->hashes[$login];
    }
}