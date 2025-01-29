<?php

namespace App\Controllers;
use App\Models\AuthModel;


class ChatController extends BaseController
{
    public function index()
    {
      $model = new AuthModel();
      $user= $model->findAll();
      return view('chatApp/index', ['user'=>$user]); 
  }
}