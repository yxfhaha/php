<?php

//打印参数
function p($val = '',$type= false)
{
    echo '<pre>';
    if($type||$val==false||@strlen($val)==1)
    {
        var_dump($val);
    }else
    {
        print_r($val);
    }
}

//GET接值方法
function get($GET=false)
{
    if($GET)
    {
        $GET = isset($_GET[$GET])?$_GET[$GET]:null;
    }else
    {
        $GET = isset($_GET)?$_GET:null;
    }
    return $_GET;
}

//POST接值方法
function post($POST=false)
{
    if($POST)
    {
        $POST = isset($_POST[$POST])?$_POST[$POST]:null;
    }else
    {
        $POST = isset($_POST)?$_POST:null;
    }
    return $POST;
}

//数据库方法
function D($TableName = false)
{
    return new library\db\db($TableName);
}

//获取配置文件内容
function C($CONFIG_NAME = false)
{
    //获取框架配置信息
    $CONFIG = include ROOT.'config/config.php';
    if($CONFIG_NAME)
    {
        if(isset($CONFIG[$CONFIG_NAME]))
        {
            return $CONFIG[$CONFIG_NAME];
        }else
        {
            return false;
        }
    }else
    {
        return $CONFIG;
    }
}


//视图函数
function view($VIEW = '',$VALUES = false,$charset = 'utf-8',$contentType = 'text/html')
{
    //时光回溯-.-
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
    unset($backtrace[0]);
    $BACKTRACE_DATA = array_pop($backtrace);
    //解析变量
    if($VALUES) $VALUES = extract($VALUES);
    $VIEW = explode('/',trim($VIEW,'/'));
    $BACKTRACE_DATA_CLASS= explode('\\',$BACKTRACE_DATA['class']);
    //判断调用
    switch (count($VIEW))
    {
        case 1;
            $ACTION_VIEW = empty($VIEW[0])?$BACKTRACE_DATA['function']:$VIEW[0];
            $CONTROLLER_VIEW = array_pop($BACKTRACE_DATA_CLASS);
        break;
        default;
            $CONTROLLER_VIEW = empty($VIEW[0])?array_pop($BACKTRACE_DATA_CLASS):$VIEW[0];
            $ACTION_VIEW = empty($VIEW[1])?$BACKTRACE_DATA['function']:$VIEW[1];
        break;
    }
    //控制器目录
    $VIEW_FILE = ROOT.'app/views/'.strtolower($CONTROLLER_VIEW).'/'.strtolower($ACTION_VIEW).'.php';
    // 网页字符编码
    header("content-type:{$contentType};charset={$charset}");
    if(is_file($VIEW_FILE))
    {
        include_once $VIEW_FILE;
    }else
    {
        die("<h3>视图层文件不存在:</h3>$VIEW_FILE");
    }
}


//打开目标目录
function library($URL = false)
{
    $URL = VENDOR.'library/'.$URL.'.php';
    if(is_file($URL))
    {
        include_once $URL;
    }else
    {
        die("<h3>类库包文件不存在,路径:</h3>$URL");
    }

}


/**
 * Application.php
 *
 * 框架自带函数
 *
 * Copyright (c)2017 http://note.hanfu8.top
 *
 * 修改历史
 * ----------------------------------------
 * 2017/9/22, 作者: 降省心(QQ:1348550820), 操作:创建
 **/

