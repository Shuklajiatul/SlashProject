<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response; // Add this line for response type

class UserController extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(); // Initialize the UserModel
    }

    public function index()
    {
        $users = $this->userModel->paginate(2);
        $data['viewpage'] = '/user/index';
        $data['data'] = ['users' => $users];
        $data['pager'] = $this->userModel->pager;
        return view('template', $data);
    }

    public function create()    
    {
        return view('user/create');
    }

    public function filter()
    {
        $filterData = $this->request->getPost();
        $users = $this->userModel->like('id', $filterData['filterId'])
                                  ->like('name', $filterData['filterName'] . '%')
                                  ->like('email', $filterData['filterEmail'] . '%')
                                  ->like('phone', $filterData['filterPhone'] . '%')
                                  ->like('role', $filterData['filterRole'] . '%')
                                  ->paginate(2);
        $data['viewpage'] = '/user/index';
        $data['data'] = ['users' => $users];  
        $data['pager'] = $this->userModel->pager;
        return view('template', $data);
    }

    public function store()
    {
        $this->userModel->save($this->request->getPost());
        return redirect()->to('/users');
    }
    
    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        return view('user/edit', $data);
    }

    public function update($id)
    {
        $this->userModel->update($id, $this->request->getPost());
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/users');
    }
}
