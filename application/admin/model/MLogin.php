<?php
namespace app\admin\model;
use think\Model;
use think\Session;
use think\Db;

class MLogin extends Model
{
    public function login($teaid,$password,$captcha)
    {
        $admin = Db::name('teacheruser') -> where('teaid','=',$teaid)-> find();
        if($admin)
        {
                if($admin[ 'password' ] == $password && captcha_check($captcha)){
                Session::set('teaid' , $teaid);
                return 1;
                   }
                else{return 2;}
        }
        else{  return 3; } 
    }

    public function changepwd($prepassword,$newpassword)
    {
        $pwd = Db::table('teacheruser')->where('teaid', session('teaid'))->find();
        if($pwd[ 'password' ] == $prepassword)
        {   
            Db::table('teacheruser')->where('teaid', session('teaid'))->update(['password' => $newpassword]);
            return true;
        }else{
            return false;
        }
    }

}
?>