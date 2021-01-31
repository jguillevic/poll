<?php

namespace Contract\Request;

interface IRequestInfoProvider {
    public function GetSubmitData() : array;
    public function IsGet() : bool;
    public function IsPost() : bool;
}