<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\MWyucadre;
use PhpOffice\PhpWord\PhpWord;

class Wyucadre extends Controller
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
        $mwyucadre = new MWyucadre;
        $wyucadre = $mwyucadre -> search(session("stuid"));
        if($wyucadre)
        {
            $this->assign('wyucadre',$wyucadre);
            return $this->fetch("show");
        }
        if(!$wyucadre)
        {
            return $this->fetch("change");
        }
     }

     //提交填写的数据
     public function postdate()
     {
        $mwyucadre = new MWyucadre;
        $mwyucadre -> savedate($_POST,session("stuid"));
        $wyucadre = $mwyucadre -> search(session("stuid"));
        $this->assign('wyucadre',$wyucadre);
        return $this->fetch("show");
     }

     //修改数据
     public function change()
     {
            $mwyucadre = new MWyucadre;
           $wyucadre = $mwyucadre -> search(session("stuid"));
           $this->assign('wyucadre',$wyucadre);
          return $this->fetch("change");
     }

     //输出数据到word文档
     public function printword()
     {
        $mwyucadre = new MWyucadre;
        $wyucadre = $mwyucadre -> search(session("stuid"));
        if($wyucadre)
        {   
            //TemplateProcessor函数跟.doc的word文件不兼容！！！
           header('Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document');
           header('Content-Disposition: attachment;filename= application.docx');//告诉浏览器将输出文件的名称(文件下载)  
           header('Cache-Control: max-age=0');//禁止缓存  
            $PHPWord = new \PhpOffice\PhpWord\PhpWord(); 
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('D:\xampp2\htdocs\scholarship\public\static\index\word\wyucadre.docx');  
            foreach ($wyucadre as $key => $value) {
                $templateProcessor->setValue($key,$value ); 
            }
            $templateProcessor->saveAs('php://output');  
        }
     }
     
}
?>