<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\MPovertysl;
use app\index\model\Mphpexcel;
use PhpOffice\PhpWord\PhpWord;

class Povertysl extends Controller
{
    //检测到未登录进行重新登录
     public function _initialize()
     {
        if (!session('stuid'))
         {
                return $this->redirect('index/Login/login');
         }
      }

      //呈现页面
     public function page()
     {
        $mpovertysl = new MPovertysl;
        $povertysl = $mpovertysl -> search(session("stuid"));
        if($povertysl)
        {
            $this->assign('povertysl',$povertysl);
            return $this->fetch("show");
        }
        if(!$povertysl)
        {
            $this->assign('povertysl',$povertysl);
            return $this->fetch("change");
        }
     }

     //提交填写的数据
     public function postdate()
     {
        $mpovertysl = new MPovertysl;
        $mpovertysl -> savedate($_POST,session("stuid"));
        $povertysl = $mpovertysl -> search(session("stuid"));
        $this->assign('povertysl',$povertysl);
        return $this->fetch("show");
     }

     //修改数据
     public function change()
     {
            $mpovertysl = new MPovertysl;
           $povertysl = $mpovertysl -> search(session("stuid"));
           $this->assign('povertysl',$povertysl);
     	return $this->fetch("change");
     }

     //输出数据到excel文档
     public function printexcel()
     {      
            $mpovertysl = new MPovertysl;
            $povertysl = $mpovertysl -> search(session("stuid"));
            $p = new Mphpexcel('D:\xampp2\htdocs\scholarship\public\static\index\excel\povertysl.xls');
            $p->add_data($povertysl);
            $p->output('povertysl.xls');
     }
     
}
?>