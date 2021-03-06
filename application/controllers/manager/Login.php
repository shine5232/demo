<?php
/**
 * @author  lgg <2692650429@qq.com>
 * @version 1.0，20180915
 * @package 后台首页
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helpers('manager_helper');
    }
	/**
     * 后台登录
     */
    public function index(){
        $admin_id = $this->session->userdata('admin_id');
        if (!empty($admin_id)) {
            header('location:'.site_url('/manager/welcome'));
        } else {
            $redirect_url = trim($this->input->get('redirect_url', true));//返回链接
            if (empty($redirect_url)) $redirect_url = site_url('/manager/welcome');
            assign('redirect_url', $redirect_url);
            display('/login.html');
        }
    }
    /**
     * 登录处理
     */
    public function login_in(){
        if(is_post()){
            $post = $this->input->post(NULL,true);
            $post['username'] = isset($post['username'])?trim($post['username']):'';
            $post['password'] = isset($post['password'])?trim($post['password']):'';
            if(!empty($post['username']) && !empty($post['password'])){
                $this->load->model('loop_model');
                $admin_data = $this->loop_model->get_where('admin', array('username' => $post['username']));
                if ($admin_data['username'] == '') {
                    error_json('用户名不存在');
                } elseif ($admin_data['password'] != md5(md5($post['password']) . $admin_data['salt'])) {
                    error_json('密码错误');
                } elseif ($admin_data['status'] != 0) {
                    error_json('帐号被管理员锁定');
                } else {
                    $this->loop_model->update_where('admin', array('lasttime' => time()), array('id' => $admin_data['id']));
                    $this->session->set_userdata('admin_id', $admin_data['id']);
                    admin_log_insert($admin_data['username'] . '登录系统');
                    error_json('y');
                }
            }else{
                error_json('账号和密码不能为空');
            }
        }else{
            error_json('数据提交格式错误');
        }
    }
    /**
     * 退出登录
     */
    public function login_out(){
        $admin_id = $this->session->userdata('admin_id');
        admin_log_insert($admin_id . '退出系统');
        $this->session->unset_userdata('admin_id');
        header('location:'.site_url('manager/login'));
    }
}