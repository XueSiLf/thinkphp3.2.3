<?php
// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think;
// 分布式文件存储类
class Storage {

    /**
     * 操作句柄
     * @var string
     * @access protected
     */
    static protected $handler    ;

    /**
     * 连接分布式文件系统
     * @access public
     * @param string $type 文件类型
     * @param array $options  配置数组
     * @return void
     */
    static public function connect($type='File',$options=array()) {
        $class  =   'Think\\Storage\\Driver\\'.ucwords($type);
        self::$handler = new $class($options);
    }

    static public function __callstatic($method,$args){
        /*echo '在静态上下文使用魔术方法调用不存在的方法';
        echo $method;*/
        //调用缓存驱动的方法
        # 判断方法存在在一个类中用method_exists(self::$handler, $method)
        if(method_exists(self::$handler, $method)){
            #call_user_func_array — 调用回调函数，并把一个数组参数作为回调函数的参数
            #call_user_func_array(string $func_name, array($param))
            return call_user_func_array(array(self::$handler,$method), $args);
        }
    }
}
