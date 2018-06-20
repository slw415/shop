<?php
namespace app\admin\controller;

class Admin
{
    public function index()
    {
        return view('admin/land');
    }
    public function register()
    {
        return view('register');
    }
}
