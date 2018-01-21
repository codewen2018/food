<?php

namespace app\admin\controller;


class IndexController extends BaseController
{

    public function index(){


        return view();

    }

    public function test(){

        dump(input('hobby'));
        return $this->fetch();
    }

}
