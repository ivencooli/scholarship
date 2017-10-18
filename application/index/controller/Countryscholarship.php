<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\MCountryscholarship;
use PhpOffice\PhpWord\PhpWord;

class Countryscholarship extends Controller
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
        $mcountryscholarship = new MCountryscholarship;
        $countryscholarship = $mcountryscholarship -> search(session("stuid"));
        if($countryscholarship)
        {
            $this->assign('countryscholarship',$countryscholarship);
            return $this->fetch("show");
        }
        if(!$countryscholarship)
        {
            return $this->fetch("change");
        }
     }

     //提交填写的数据
     public function postdate()
     {
        $mcountryscholarship = new MCountryscholarship;
        $mcountryscholarship -> savedate($_POST,session("stuid"));
        $countryscholarship = $mcountryscholarship -> search(session("stuid"));
        $this->assign('countryscholarship',$countryscholarship);
        return $this->fetch("show");
     }

     //修改数据
     public function change()
     {
            $mcountryscholarship = new MCountryscholarship;
           $countryscholarship = $mcountryscholarship -> search(session("stuid"));
           $this->assign('countryscholarship',$countryscholarship);
          return $this->fetch("change");
     }

     //输出数据到word文档
     public function printword()
     {
        $mcountryscholarship = new MCountryscholarship;
        $countryscholarship = $mcountryscholarship -> search(session("stuid"));
        if($countryscholarship)
        {   
            //TemplateProcessor函数跟.doc的word文件不兼容！！！
           header('Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document');
           header('Content-Disposition: attachment;filename= application.docx');//告诉浏览器将输出文件的名称(文件下载)  
           header('Cache-Control: max-age=0');//禁止缓存  
            $PHPWord = new \PhpOffice\PhpWord\PhpWord(); 
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('D:\xampp2\htdocs\scholarship\public\static\index\word\countryscholarship.docx');  
            foreach ($countryscholarship as $key => $value) {
                $templateProcessor->setValue($key,$value ); 
            }
            $zhkpA=$zhkpB= '□';
            if( $countryscholarship["zhkp"] == '是' ) {
                $zhkpA = '■';
            } elseif( $countryscholarship["zhkp"] == '否' ) {
                $zhkpB = '■';
            } 
            $templateProcessor->setValue('zhkpA',$zhkpA); 
            $templateProcessor->setValue('zhkpB',$zhkpB); 
            $templateProcessor->saveAs('php://output');  
        }
     }
     
}
?>