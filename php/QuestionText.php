<?php

class Foo {
    public $aMemberVar;

    function __construct() {
        $this->aMemberVar="ciculiky";
    }

    function getCicky(){
        return $this->aMemberVar;
    }
}