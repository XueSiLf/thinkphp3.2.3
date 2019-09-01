<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//----------------------------------
// ThinkPHP公共入口文件
//----------------------------------

### 这个文件包含require在入口文件index.php里面

// 记录开始运行时间
### 定义全局变量记录开始运行时间 微妙数
// $GLOBALS['_beginTime'] = microtime(TRUE);
$GLOBALS['_beginTime'] = microtime(TRUE);
// echo $GLOBALS['_beginTime'];
// die;
// 
// 记录内存初始使用
### 记录内存初始化使用 
#先判断是否支持内存使用函数
define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));
#如果支持然后设置全局变量内存初始化时内存占用
if(MEMORY_LIMIT_ON) $GLOBALS['_beginUseMems'] = memory_get_usage();
// define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));
// if(MEMORY_LIMIT_ON) $GLOBALS['_startUseMems'] = memory_get_usage();
## var_dump($GLOBALS);
## echo in_array('_beginTime', $GLOBALS);
## die;


### 定义一些常量
const THINK_VERSION     =   '3.2.3';
// define('THINK_VERSION1', '3.2.3');
// echo THINK_VERSION1;
// echo '<br >';
// 版本信息
#const THINK_VERSION     =   '3.2.3';

// URL 模式定义
const URL_COMMON        =   0;  //普通模式
const URL_PATHINFO      =   1;  //PATHINFO模式
const URL_REWRITE       =   2;  //REWRITE模式
const URL_COMPAT        =   3;  // 兼容模式

// 类文件后缀
const EXT               =   '.class.php'; 



// 系统常量定义
defined('THINK_PATH')   or define('THINK_PATH',     __DIR__.'/');
defined('APP_PATH')     or define('APP_PATH',       dirname($_SERVER['SCRIPT_FILENAME']).'/');
#echo dirname($_SERVER['SCRIPT_FILENAME']);
// D:/mysoftware/PHP/wamp64/www/tp3_demo/thinkphp_3.2.3_full
#die;
defined('APP_STATUS')   or define('APP_STATUS',     ''); // 应用状态 加载对应的配置文件
defined('APP_DEBUG')    or define('APP_DEBUG',      false); // 是否调试模式

if(function_exists('saeAutoLoader')){// 自动识别SAE环境
    // echo 1;
    // die;
    defined('APP_MODE')     or define('APP_MODE',      'sae');
    defined('STORAGE_TYPE') or define('STORAGE_TYPE',  'Sae');
}else{
    # wamp环境默认不开启 SAE环境
    # echo 0;die;
    # 定义应用模式
    defined('APP_MODE')     or define('APP_MODE',       'common'); // 应用模式 默认为普通模式    
    # 定义存储类型
    defined('STORAGE_TYPE') or define('STORAGE_TYPE',   'File'); // 存储类型 默认为File    
    #echo APP_MODE;
    #echo STORAGE_TYPE;
    #die;
}

defined('RUNTIME_PATH') or define('RUNTIME_PATH',   APP_PATH.'Runtime/');   // 系统运行时目录
defined('LIB_PATH')     or define('LIB_PATH',       realpath(THINK_PATH.'Library').'/'); // 系统核心类库目录
defined('CORE_PATH')    or define('CORE_PATH',      LIB_PATH.'Think/'); // Think类库目录
defined('BEHAVIOR_PATH')or define('BEHAVIOR_PATH',  LIB_PATH.'Behavior/'); // 行为类库目录
defined('MODE_PATH')    or define('MODE_PATH',      THINK_PATH.'Mode/'); // 系统应用模式目录
defined('VENDOR_PATH')  or define('VENDOR_PATH',    LIB_PATH.'Vendor/'); // 第三方类库目录
defined('COMMON_PATH')  or define('COMMON_PATH',    APP_PATH.'Common/'); // 应用公共目录
defined('CONF_PATH')    or define('CONF_PATH',      COMMON_PATH.'Conf/'); // 应用配置目录
defined('LANG_PATH')    or define('LANG_PATH',      COMMON_PATH.'Lang/'); // 应用语言目录
defined('HTML_PATH')    or define('HTML_PATH',      APP_PATH.'Html/'); // 应用静态目录
defined('LOG_PATH')     or define('LOG_PATH',       RUNTIME_PATH.'Logs/'); // 应用日志目录
defined('TEMP_PATH')    or define('TEMP_PATH',      RUNTIME_PATH.'Temp/'); // 应用缓存目录
defined('DATA_PATH')    or define('DATA_PATH',      RUNTIME_PATH.'Data/'); // 应用数据目录
defined('CACHE_PATH')   or define('CACHE_PATH',     RUNTIME_PATH.'Cache/'); // 应用模板缓存目录
defined('CONF_EXT')     or define('CONF_EXT',       '.php'); // 配置文件后缀
defined('CONF_PARSE')   or define('CONF_PARSE',     '');    // 配置文件解析方法
defined('ADDON_PATH')   or define('ADDON_PATH',     APP_PATH.'Addon');

// 系统信息
if(version_compare(PHP_VERSION,'5.4.0','<')) {
    # php版本 小于 5.4.0，默认不激活。 设置当前 magic_quotes_runtime 配置选项的激活状态
    ini_set('magic_quotes_runtime',0);
    define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc()? true : false);
}else{
    define('MAGIC_QUOTES_GPC',false);
}
#var_dump(MAGIC_QUOTES_GPC);//false
/*echo PHP_SAPI;//apache2handler
var_dump(strpos(PHP_SAPI,'cgi'));//false*/

define('IS_CGI',(0 === strpos(PHP_SAPI,'cgi') || false !== strpos(PHP_SAPI,'fcgi')) ? 1 : 0 );
#echo IS_CGI; //0 注意是全等符号哦 不自动转换类型


define('IS_WIN',strstr(PHP_OS, 'WIN') ? 1 : 0 );
#echo PHP_OS;
#var_dump(strstr(PHP_OS, 'WIN')); //'WINNT'
#echo IS_WIN;//1

define('IS_CLI',PHP_SAPI=='cli'? 1   :   0);
#echo IS_CLI;//0

## 非cli交互模式
if(!IS_CLI) {
    // 当前文件名  未定义_PHP_FILE_
    if(!defined('_PHP_FILE_')) {
        // CGI模式
        if(IS_CGI) {
            //CGI/FASTCGI模式下
            $_temp  = explode('.php',$_SERVER['PHP_SELF']);
            define('_PHP_FILE_',    rtrim(str_replace($_SERVER['HTTP_HOST'],'',$_temp[0].'.php'),'/'));
        }else {
            # 非CGI模式
            # 定义_PHP_FILE_
            define('_PHP_FILE_',    rtrim($_SERVER['SCRIPT_NAME'],'/'));//当前执行脚本文件
            #echo _PHP_FILE_;
            #var_dump($_SERVER);
            #die;
        }
    }
    # 判断是否定义网站根目录
    if(!defined('__ROOT__')) {
        $_root  =   rtrim(dirname(_PHP_FILE_),'/');
        #echo $_root;// \
        define('__ROOT__',  (($_root=='/' || $_root=='\\')?'':$_root));
        #echo __ROOT__;// ''
        #die;
    }
}

# 属于ThinkPHP 属于入口文件index.php
#echo CORE_PATH.'Think'.EXT; //D:\mysoftware\PHP\wamp64\www\tp3_demo\thinkphp_3.2.3_full\ThinkPHP\Library/Think/Think.class.php
// 加载核心Think类
require CORE_PATH.'Think'.EXT;
// 应用初始化 
# 调用核心Think类的 start()方法
Think\Think::start();