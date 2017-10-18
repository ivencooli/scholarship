<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\MCountryencscholarship;
use PhpOffice\PhpWord\PhpWord;

class Countryencscholarship extends Controller
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
        $mcountryencscholarship = new MCountryencscholarship;
        $countryencscholarship = $mcountryencscholarship -> search(session("stuid"));
        if($countryencscholarship)
        {
            $this->assign('countryencscholarship',$countryencscholarship);
            return $this->fetch("show");
        }
        if(!$countryencscholarship)
        {
            return $this->fetch("change");
        }
     }

     //提交填写的数据
     public function postdate()
     {
        $mcountryencscholarship = new MCountryencscholarship;
        $mcountryencscholarship -> savedate($_POST,session("stuid"));
        $countryencscholarship = $mcountryencscholarship -> search(session("stuid"));
        $this->assign('countryencscholarship',$countryencscholarship);
        return $this->fetch("show");
     }

     //修改数据
     public function change()
     {
            $mcountryencscholarship = new MCountryencscholarship;
           $countryencscholarship = $mcountryencscholarship -> search(session("stuid"));
           $this->assign('countryencscholarship',$countryencscholarship);
     	return $this->fetch("change");
     }

     //输出数据到word文档
     public function printword()
     {
        $mcountryencscholarship = new MCountryencscholarship;
        $countryencscholarship = $mcountryencscholarship -> search(session("stuid"));
        if($countryencscholarship)
        {   
            //TemplateProcessor函数跟.doc的word文件不兼容！！！
           header('Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document');
           header('Content-Disposition: attachment;filename= application.docx');//告诉浏览器将输出文件的名称(文件下载)  
           header('Cache-Control: max-age=0');//禁止缓存  
            $PHPWord = new \PhpOffice\PhpWord\PhpWord(); 
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('D:\xampp2\htdocs\scholarship\public\static\index\word\countryencscholarship.docx');  
            foreach ($countryencscholarship as $key => $value) {
                $templateProcessor->setValue($key,$value ); 
            }
            $kncdA=$kncdB= $kncdC='□';
            if( $countryencscholarship["kncd"] == '一般困难' ) {
                $kncdA = '■';
            } elseif( $countryencscholarship["kncd"] == '困难' ) {
                $kncdB = '■';
            } elseif( $countryencscholarship["kncd"] == '特殊困难' ) {
                $kncdC = '■';
            } 
            $templateProcessor->setValue('kncdA',$kncdA); 
            $templateProcessor->setValue('kncdB',$kncdB); 
            $templateProcessor->setValue('kncdC',$kncdC);
            $pmpxA=$pmpxB= $pmpxC='□';
            if( $countryencscholarship["pmpx"] == '按专业' ) {
                $pmpxA = "■";
            } elseif( $countryencscholarship["pmpx"] == '按年级' ) {
                $pmpxB = "■";
            } elseif( $countryencscholarship["pmpx"] == '按班级' ) {
                $pmpxC = "■";
            } 
            $templateProcessor->setValue('pmpxA',$pmpxA); 
            $templateProcessor->setValue('pmpxB',$pmpxB); 
            $templateProcessor->setValue('pmpxC',$pmpxC);
            $templateProcessor->saveAs('php://output');  
        }
     }
     
}
?>