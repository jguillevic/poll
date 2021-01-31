<?php

namespace Helper\Request;

use Contract\Request\IRequestInfoProvider;

class RequestInfoProvider implements IRequestInfoProvider {
    public function GetSubmitData() : array {
        if ($this->IsGet())
            return $_GET;
        else if ($this->IsPost())
            return $_POST;
        else
            return [];
    }

    public function IsGet() : bool {
        return $_SERVER['REQUEST_METHOD'] == "GET";
    }

    public function IsPost() : bool {
        return $_SERVER['REQUEST_METHOD'] == "POST";
    }
}