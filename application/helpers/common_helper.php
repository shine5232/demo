<?php
/**
 * @author  lgg <2692650429@qq.com>
 * @version 1.0，20180915
 * @package 自定义全局函数
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//开启调试
$CI = &get_instance();
$CI->output->enable_profiler(false);

/**
 * smarty 加载变量
 * @param str $name 变量名
 * @param str $data 变量值
 */
if (!function_exists('assign')) {
    function assign($name = FALSE, $data = FALSE)
    {
        if ($name !== FALSE) {
            $CI = &get_instance();
            $CI->load->library('my_smarty');
            $CI->my_smarty->assign($name, $data);
        }
    }
}
/**
 * smarty 加载模板
 * @param str $tmp_name 模板地址
 */
if(!function_exists('display')){
	function display($tmp_name = FALSE){
		if($tmp_name !== FALSE){
			$CI = &get_instance();
			$CI->load->library('my_smarty');
			$CI->my_smarty->display(get_web_type() . $tmp_name);
		}
	}
}
/**
 * 获取当前的web网站类型(web/mobile)
 */
if (!function_exists('get_web_type')) {
    function get_web_type()
    {
        $CI       = &get_instance();
        $web_type = $CI->uri->segment(1);//根据网址的第一段来区分是web还是mobile
        if ($web_type != 'mobile' && $web_type != 'manager') {
            $web_type = 'web';
        }
        return $web_type;
    }
}
/**
 * 返回错误信息json格式
 * @param str $info   提示信息
 * @param str $status 状态
 * @return json
 */
if (!function_exists('error_json')) {
    function error_json($info = '信息错误', $status = 'n')
    {
        if ($info == 'y') {
            exit(json_encode(array('status' => 'y')));
        } else {
            if (is_array($info)) {
                $status = 'y';
                if (!empty($info['status'])) {
                    $status = $info['status'];
                    unset($info['status']);
                }
                $res = array(
                    'result' => $info,
                    'status' => $status,
                );
                exit(json_encode($res));
            } else {
                exit(json_encode(array('info' => $info, 'status' => $status)));
            }
        }
    }
}
/**
 * 判断是否是post提交
 */
if (!function_exists('is_post')) {
    function is_post()
    {
        $CI = &get_instance();
        if (strtolower($CI->input->server('REQUEST_METHOD')) == 'post') {
            return true;
        } else {
            return false;
        }
    }
}
/**
 * 提示信息框,适应手机端页面
 * @param str $msg     提示信息
 * @param str $url     跳转链接
 * @param int $outtime 提示页面停留时间
 *
 */
if (!function_exists('msg')) {
    function msg($msg = FALSE, $url = '-1', $skip_time = '2000')
    {
        $base_url = base_url();
        if ($msg !== FALSE) {
            if ($url == '-1' || $url == '') {
                $url_str = "history.back(-1)";
            } elseif ($url == 'x') {
                $url_str = "layer_close()";
            }else{
                $url_str = "window.location.href='$url'";
            }
            //url等于stop时不允许跳转
            if ($url != 'stop') {
                $skip_url = '<script language="javascript">setTimeout("' . $url_str . '",' . $skip_time . ');</script>';
            } else {
                $skip_url = '';
            }
            echo <<<Eof
                <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=uft-8"/>
                        <title>提示信息</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
                    </head>
                    <body>
                        <script language="javascript" src="$base_url/public/js/jquery.js"></script>
                        <script language="javascript" src="$base_url/public/js/layer/layer.js"></script>
                        <script language="javascript">
                        layer.msg('$msg');
                        </script>
                        $skip_url
                    </body>
                </html>
Eof;
            exit;
        }
    }
}
/**
 * 得到当前页面的网址
 */
if (!function_exists('get_now_url')) {
    function get_now_url()
    {
        $domain = $_SERVER['HTTP_HOST'];
        if (!empty($_SERVER['HTTPS'])) {
            $pageURL = 'https://' . $domain;
        } else {
            $pageURL = 'http://' . $domain;
        }
        $pageURL .= $_SERVER["REQUEST_URI"];
        return $pageURL;
    }
}