<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\Profile;
use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        $user = new User;

        $dataHistory = $this->historyModel();
        $dataGejala = $this->gejala();
        $auth = $this->authService();
        $dataUser = $this->auth->user();
        $AllUser = $user->findAll();
        $data=[
            'title'=>'Admin Dashboard',
            'gejala' => $dataGejala,
            'history' => $dataHistory,
            'AllUser' => $AllUser,
            'user' => $dataUser->username
        ];   
        echo view('templates/header', $data);
        echo view('templates/sidebar-admin');
        echo view('templates/topbar');
        echo view('admin/index');
        echo view('templates/footer');
    }


    public function dataUser()
    {
        $user = new User;
        $auth = $this->authService();
        $dataUser = $this->auth->user();
        $AllUser = $user->findAll();
        $data=[
            'title'=>'Data Pengguna',
            'user' => $dataUser->username,
            'AllUser' => $AllUser 
        ];
        echo view('templates/header', $data);
        echo view('templates/sidebar-admin');
        echo view('templates/topbar');

        echo view('admin/data-user');
        
        echo view('templates/footer');
    }

    public function dataGejala()
    {
        $auth = $this->authService();
        $dataUser = $this->auth->user();
        $dataGejala = $this->gejala();
        $data=[
            'title'=>'Data Gejala',
            'gejala' => $dataGejala,
            'user' => $dataUser->username
        ];
        echo view('templates/header', $data);
        echo view('templates/sidebar-admin');
        echo view('templates/topbar');
        echo view('admin/data-gejala');     
        echo view('templates/footer');
    }
    public function history()
    {
        $auth = $this->authService();
        $dataUser = $this->auth->user();
        $dataHistory = $this->historyModel();
        $dataProfile = $this->profileModel();
        $data=[
            'title'=>'Data Pemeriksaan',
            'history' => $dataHistory,
            'profile' => $dataProfile,
            'user' => $dataUser->username
        ];

        echo view('templates/header', $data);
        echo view('templates/sidebar-admin');
        echo view('templates/topbar');
        echo view('admin/history-admin');    
        echo view('templates/footer');
    }
    public function tambahGejala()
    {
        $auth = $this->authService();
        $dataUser = $this->auth->user();
        
        $data=[
            'title'=>'Tambah Data Gejala',
            'user' => $dataUser->username
        ];
        echo view('templates/header', $data);
        echo view('templates/sidebar-admin');
        echo view('templates/topbar');
        echo view('admin/tambah-gejala');     
        echo view('templates/footer');
    }
    public function saveTambahGejala(){
        $data = $this->request->getVar();
        $dataGejala = $this->gejalaModel->insert($data);
        session()->setFlashdata('msg','Tambah data gejala berhasil');
        return redirect('admin/data-gejala');
    }
        
    public function getDataUser(){
        $id =  $_POST['id'];
        $dataHistory = $this->historyModel();
        foreach ($dataHistory['history'] as $hs) {
            if ($hs['id'] == $id) {
                $username = $hs['nama'];
                if ($username = $hs['nama']) {  
                    foreach ($this->profileModel->find() as $key) {
                        if ($key['username']==$username) {
                            echo json_encode($key); 
                        }
                    }                
                }
            }
        }
    }
}
