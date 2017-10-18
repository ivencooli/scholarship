<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MLogin extends Model
{
    public function login($stuid,$password,$captcha)
    {
        $admin = Db::name('studentuser') -> where('stuid','=',$stuid)-> find();
        if($admin)
        {
                if($admin[ 'password' ] == $password && captcha_check($captcha)){
                Session::set('stuid' , $stuid);
                return 1;
                   }
                else{return 2;}
        }
        else{  return 3; } 
    }

    public function changepwd($prepassword,$newpassword)
    {
        $pwd = Db::table('studentuser')->where('stuid', session('stuid'))->find();
        if($pwd[ 'password' ] == $prepassword)
        {   
            Db::table('studentuser')->where('stuid', session('stuid'))->update(['password' => $newpassword]);
            return true;
        }else{
            return false;
        }
    }

}
?>