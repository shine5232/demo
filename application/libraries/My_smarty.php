<?php
/** 
 * @author lgg <2692650429@qq.com>
 * @version 1.0 20180915
 * @package smarty模板配置
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . 'third_party/smarty/Smarty.class.php');

Class My_smarty extends Smarty{
	
	public function __construct(){
		parent::__construct();
		$this->template_dir = APPPATH.'../views';
        $this->compile_dir = APPPATH . 'cache/runtime';
        $this->left_delimiter = '<{';
        $this->right_delimiter = '}>';
	}
}