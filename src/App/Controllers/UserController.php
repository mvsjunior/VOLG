<?php

namespace App\Controllers;

use App\Models\UserRepository;
use Core\Http\BaseController;

final class UserController extends BaseController {

    private UserRepository $userRepo;

    public function __construct($container){
        parent::__construct($container);
        $this->userRepo = $this->container->get(\App\Models\UserRepository::class);
    }

    public function index(){
        header('content-type: application/json');
        echo json_encode($this->userRepo->fetchAll(['id', 'name','email','created_at']));
    }
}