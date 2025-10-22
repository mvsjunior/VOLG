<?php

namespace App\Controllers;

use App\Models\UserRepository;
use Core\Http\BaseController;
use Volg\Core\Http\Request;

final class UserController extends BaseController {

    private UserRepository $userRepo;

    public function __construct($container){
        parent::__construct($container);
        $this->userRepo = $this->container->get('UserRepository');
    }

    public function index(){

        header('content-type: application/json');

        $request = new Request;
        $page = $request->get('p',1);
        $perPage = $request->get('pp',8);

        $resultPaginated = $this->userRepo->fetchAllPaginated(['id','name', 'email'],$perPage,$page);
        

        echo json_encode($resultPaginated);
    }
}