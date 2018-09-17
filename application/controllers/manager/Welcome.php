<?php
/**
 * @author  lgg <2692650429@qq.com>
 * @version 1.0，20180915
 * @package 后台首页
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helpers('manager_helper');
        $this->admin_data = manager_login();
        assign('admin_data', $this->admin_data);
    }
	/**
     * 后台首页
     */
    public function index(){
        display('/index/index.html');
    }
    /**
     * 后台头部
     */
    public function header(){
        display('/index/header.html');
    }
}