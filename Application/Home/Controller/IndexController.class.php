<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	echo THINK_VERSION;die;
        $this->show('ThinkPHP3.2.3_full','utf-8');
    }

    public function hello()
    {
        // 调用公共函数hello()
    	// hello();// hello
        echo 'hello,thinkphp!';
    }

    public function test()
    {
        echo 'test';
    }

    /**
     * 配置中开启操作方法后缀
     * 'ACTION_SUFFIX'         =>  'Action', // 操作方法后缀
     * 则需要定义操作方法为
     * URL访问无影响
     */
    /*public function helloAction()
    {
        echo 'eee';
    }*/
}