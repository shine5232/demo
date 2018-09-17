<?php
/**
 * @author  lgg <2692650429@qq.com>
 * @version 1.0，20180915
 * @package 后台商品首页
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helpers('manager_helper');
        $this->admin_data = manager_login();
        assign('admin_data', $this->admin_data);
    }
	/**
     * 商品列表
     */
    public function index(){
        display('/goods/index.html');
    }
    /**
     * 商品删除
     */
    public function goods_del(){
        $data = $this->input->get(NULL,true);
        if(!empty($data)){
            error_json('y');
        }else{
            error_json('数据为空');
        }
    }
}