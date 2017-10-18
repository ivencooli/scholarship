<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\MCountrygrants;
use PhpOffice\PhpWord\PhpWord;

class Countrygrants extends Controller
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
        $mcountrygrants = new MCountrygrants;
        $countrygrants = $mcountrygrants -> search(session("stuid"));
        if($countrygrants)
        {
            $this->assign('countrygrants',$countrygrants);
            return $this->fetch("show");
        }
        if(!$countrygrants)
        {
            return $this->fetch("change");
        }
     }

     //提交填写的数据
     public function postdate()
     {
        $mcountrygrants = new MCountrygrants;
        $mcountrygrants -> savedate($_POST,session("stuid"));
        $countrygrants = $mcountrygrants -> search(session("stuid"));
        $this->assign('countrygrants',$countrygrants);
        return $this->fetch("show");
     }

     //修改数据
     public function change()
     {
            $mcountrygrants = new MCountrygrants;
           $countrygrants = $mcountrygrants -> search(session("stuid"));
           $this->assign('countrygrants',$countrygrants);
          return $this->fetch("change");
     }

     //输出数据到word文档
     public function printword()
     {
        $mcountrygrants = new MCountrygrants;
        $countrygrants = $mcountrygrants -> search(session("stuid"));
        if($countrygrants)
        {   
            //TemplateProcessor函数跟.doc的word文件不兼容！！！
           header('Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document');
           header('Content-Disposition: attachment;filename= application.docx');//告诉浏览器将输出文件的名称(文件下载)  
           header('Cache-Control: max-age=0');//禁止缓存  
            $PHPWord = new \PhpOffice\PhpWord\PhpWord(); 
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('D:\xampp2\htdocs\scholarship\public\static\index\word\countrygrants.docx');  
            foreach ($countrygrants as $key => $value) {
                $templateProcessor->setValue($key,$value ); 
            }
            $kncdA=$kncdB= $kncdC='□';
            if( $countrygrants["kncd"] == '一般困难' ) {
                $kncdA = '■';
            } elseif( $countrygrants["kncd"] == '困难' ) {
                $kncdB = '■';
            } elseif( $countrygrants["kncd"] == '特殊困难' ) {
                $kncdC = '■';
            } 
            $templateProcessor->setValue('kncdA',$kncdA); 
            $templateProcessor->setValue('kncdB',$kncdB); 
            $templateProcessor->setValue('kncdC',$kncdC);
            $templateProcessor->saveAs('php://output');  
        }
     }
     
}
?>