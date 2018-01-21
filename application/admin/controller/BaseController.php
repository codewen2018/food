<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use think\Controller;
use think\Db;

class BaseController extends Controller
{
    //

    public function _initialize()
    {
        $controller = request()->controller();
        $action = request()->action();
        $route=strtolower($controller."/".$action);

        //白名单
        $allowRoute=[
            'admin/login',
            'admin/logout',
        ];


        //判断有没有autoLogin
        if ($autoLogin=cookie('autoLogin')) {

        // $admin=Db::name('admin')->find(['id'=>$autoLogin[0],'auth_key'=>$autoLogin[1]]);
         $admin=Admin::get(['id'=>$autoLogin[0],'auth_key'=>$autoLogin[1]]);
         if ($admin){
             //设置Session
             session('admin',$admin['id']);
             //并更换Token值
             $admin->auth_key=md5(uniqid());
             $admin->save();

             //保存Token到Cookie
             cookie("autoLogin",[$admin->id,$admin->auth_key],3600*24*7);


         }
        }



        //如果不是白名单里面的路由才需要权限验证
        if (in_array($route,config('allowRoute'))===false){

            if (!session('admin')) {

                return $this->redirect('/admin/admin/login');

            }


           /* $auth =new \think\auth\Auth();
            if(!$auth->check($controller . '/' . $action, session('uid'))){
                $this->error('你没有权限访问');
            }*/
        }

        parent::_initialize();
    }
}
