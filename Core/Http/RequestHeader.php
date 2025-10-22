<?php

namespace Volg\Core\Http;

class RequestHeader{
    protected Array $server = [];

    public function __construct(Array $server = []){
        $this->server = sizeof($server) == 1 ? $_SERVER : $server;
    }

    public function get(String $key = '', $default = null){

        if($key == ''){
            return $this->server;
        }

        if(isset($this->server[$key])){
            return $this->server[$key];
        }

        $key = $this->parseNormalizeHeaderToPHPFormat($key);

        return isset($this->server[$key]) ? $this->server[$key] : $default;
    }

    public function parseNormalizeHeaderToPHPFormat(String $key = ''){
        $key = strtoupper($key);
        $key = str_replace("-","_",$key);
        return $key;
    }
}