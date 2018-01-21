<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use think\Controller;
use think\Request;

class AdminController extends BaseController
{

    public function index()
    {

        dump(session('admin'));
        return 111;
    }

    public function login()
    {

        if (\request()->isPost()) {

            //判断用户名是否存在
            $admin = Admin::get(['username' => input('username')]);

            //
          if ($admin && password_verify(input("password"),$admin->password)){
              //用户名存在并且密码正确  保存Session

              session('admin',$admin->id);

              //判断有没有记住密码
              if (input('rememberMe')){
                  //保存Token到Cookie
                  cookie("autoLogin",[$admin->id,$admin->auth_key],3600*24*7);

              }

              $this->success("登录成功",'index');
              //return $this->redirect('index');


          }else{


             $this->error("用户名或密码错误");


          }


        }

        return view('login');
    }

    public function logout(){

        //清空admin
        session('admin',null);
        //清Cookie
        cookie('autoLogin',null);



        $this->redirect(url("admin/admin/login"));
    }

}
