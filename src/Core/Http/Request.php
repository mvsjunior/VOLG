<?php

namespace Volg\Core\Http;

use Volg\Core\Http\RequestHeader;

class Request {
    protected Array $data = [];
    protected Array $get = [];
    protected Array $post = [];
    protected Array $patch = [];
    protected Array $delete = [];
    protected Array $request = [];
    public RequestHeader $header;

    public function __construct(){
        $this->header = new RequestHeader($_SERVER);
        $this->get = ($this->isJsonRequest() && $this->header->get('REQUEST_METHOD') == 'GET') ? array_merge($_GET, $this->getJsonBodyData()) : $_GET;
        $this->post = ($this->isJsonRequest() && $this->header->get('REQUEST_METHOD') == 'POST') ? array_merge($_POST, $this->getJsonBodyData()) : $_POST;   
        $this->request = $this->isJsonRequest() ? array_merge($_REQUEST, $this->getJsonBodyData()) : $_REQUEST;
        $this->delete = $this->request;
        $this->patch = $this->request;
    }

    public function get(string $key = "", $defaultValue = null){
        if($key == "") {
            return $this->get;
        }

        if(!isset($this->get[$key])){
            return $defaultValue;
        }

        return filter_var($this->get[$key], FILTER_DEFAULT);
    }

    public function post(string $key = "", $defaultValue = null){
        if($key == "") {
            return $this->post;
        }

        if(!isset($this->post[$key])){
            return $defaultValue;
        }

        return filter_var($this->post[$key], FILTER_DEFAULT);;
    }

    public function request(string $key = "", $defaultValue = ""){

        if($key == "") {
            return $this->request;
        }

        if(!isset($this->request[$key])){
            return $defaultValue;
        }

        return filter_var($this->request[$key], FILTER_DEFAULT);
    }

    public function isJsonRequest(){
        return $this->header->get('content-type', false) == 'application/json' ? $this->header->get('content-type', false) : false;
    }

    public function getJsonBodyData(): Array{
        return json_decode(file_get_contents('php://input'), true);
    }

    public function header(){
        return $this->header;
    }
}