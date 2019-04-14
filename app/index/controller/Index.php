<?php
namespace app\index\controller;
header("Content-Type:text/html; charset=utf-8");


use think\Request;
use think\Controller;
use app\index\model\User;
use app\index\model\Email;


class Index extends Controller
{

	/*主页控制器*/
    public function index()
    {
		return $this->fetch('index',[
			'title' => '无价宝商城-购最便宜产品、秒杀0.1产品、优惠是品牌'
		]);
    }


	/*登录页控制器*/
    public function login()
    {
		return $this->fetch('login',[
			'title' => '登录页面'	
		]);
    }


	/*注册页控制器*/
    public function reg()
    {
		return $this->fetch('reg',[
			'title' => '注册页面'	
		]);
    }


    /*登录验证用户名控制器*/
    public function loginCheck_username(Request $request)
    {
        $where=[
            'username' => $request->post('username')
        ];
        //判断条件
        if(!(new User)->select($where)){ echo 0; }
        else{ echo 1; }
    }


    /*验证密码控制器*/
    public function loginChk(Request $request)
    {
        $where=[
            'username' => $request->post('username'),
            'password' => md5($request->post('password'))
        ];
        //判断条件
       if(!(new User)->select($where)){
           echo $this->fetch('login',[
               'warn' => '密码错误'
           ]);
       }else{
           echo $this->fetch('index');
       }
    }


	/*email邮箱验证是否注册*/
	public function email(Request $request)
	{
        $where=[
            'email' => $request->post('email')
        ];
        //判断条件
        if(!(new User)->select($where)){ echo 1; }
        else{ echo 0; }
	}


	/*发送邮箱验证码*/
	public function emailCode(Request $request)
	{
        $where= $request->post('email');

        $code = (new Email)->sendEmail($where);
        echo $code;
	}

	/*过渡email信息到填写资料板块给regfileChk操作插入数据库*/
	public function regChk(Request $request)
	{
		$email=$request->post('email');
		return $this->fetch('regFile',[
			'title' => '注册页面',
			'email' => $email	
		]);
	}
    /**
     * 插入数据库
     * @param Request $request
     * @return mixed
     */
	public function regFileChk(Request $request)
	{
		$data=[
            'username' => $request->post('username'),
            'password' => md5($request->post('password')),
            'email' => $request->post('email'),
        ];
		/*验证用户是否是通过url漏洞过来的*/
		if(($request->post('email'))==null){
			return $this->fetch('reg',[
				'warn' => '小老弟先验证邮箱'	
			]);
		}else{
			if((new User)->insert($data)){
                echo '<script>alert("注册成功");</script>';
			    return $this->fetch('login');
			}else{
                echo '<script>alert("注册失败");</script>';
			    return $this->fetch('reg');
			}
		}	
	}


	//忘记密码板块
	public function forgetPassword(Request $request)
	{
		return $this->fetch('forgetPassword',[
			'title' => '找回密码',
		]);
	}


	//username还没传值
	public function forgetPasswordChk(Request $request)
	{
        $where=[
            'email' => $request->post('email')
        ];

        $result = (new User)->select($where);

		return $this->fetch('forgetPasswordFile',[
			'title' => '找回密码',
			'username' => $result['username'],
			'email' => $result['email']
        ]);
	}
	public function ChangePassword(Request $request)
	{
        $where=[
            'email' => $request->post('email'),
        ];
        $data=[
                'password' => md5($request->post('password')),
        ];

		if((new User)->_update($where,$data)){
			echo '<script>alert("修改密码成功");</script>';
			return $this->fetch("login",[
				'title' => '登录页面'
			]);
		}else{
			echo '<script>alert("修改密码失败");</script>';
			return $this->fetch("login",[
				'title' => '登录页面'
			]);
		}
	}

}
