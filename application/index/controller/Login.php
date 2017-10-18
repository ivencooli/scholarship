<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\MLogin;

class Login extends Controller
{
    //加载登录页面
     public function login()
     {
     	if(session("stuid")){
        return $this->fetch("welcome");
     	}else{
      	return $this->fetch("login");
     	}
     }

     //进行登录
     public function login_in()
     {

     	 if(request() -> isPost())    //验证表单提交的账户和密码
            {
                    $log = new MLogin;
                    $status = $log -> login(input("stuid"),input("password"),input('captcha'));
                     if($status == 1){
                      $a = session('stuid');
                      echo "<script>alert('登录成功！'+'$a'+'欢迎使用');</script>";
                      return $this->fetch("welcome");
                     }if($status == 2){
                        echo "<script>alert('密码或验证码错误！!');location.href='login';</script>";//利用js重新刷新
                     }if($status == 3){
                        echo "<script>alert('用户不存在!');location.href='login';</script>";//利用js重新刷新
                     }
             }
     }

     //退出登录
     public function login_out()
     {
     	session(null);
       	return $this->fetch("login");
     }

   
       public function changepwd()
     {
           if(request() -> isPost())    
           {
                  $log = new MLogin;
                  $status = $log -> changepwd(input("prepassword"),input("newpassword"));
                  if($status)//修改成功
                  {
                    echo "<script>alert('修改成功!');location.href='changepwd';</script>";//利用js重新刷新
                  }
                  if(!$status)//修改失败
                  {
                        echo "<script>alert('原密码错误!');location.href='changepwd';</script>";//利用js重新刷新
                  }
           }
           else
           {
                return $this->fetch("changepwd");
           }
     }

}
?>