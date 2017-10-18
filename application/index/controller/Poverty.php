<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\MPoverty;
use PhpOffice\PhpWord\PhpWord;

class Poverty extends Controller
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
        $mpoverty = new MPoverty;
        $poverty = $mpoverty -> search(session("stuid"));
        if($poverty)
        {
            $this->assign('poverty',$poverty);
            return $this->fetch("show");
        }
        if(!$poverty)
        {
            $this->assign('poverty',$poverty);
            return $this->fetch("change");
        }
     }

     //提交填写的数据
     public function postdate()
     {
        $mpoverty = new MPoverty;
        $mpoverty -> savedate($_POST,session("stuid"));
        $poverty = $mpoverty -> search(session("stuid"));
        $this->assign('poverty',$poverty);
        return $this->fetch("show");
     }

     //修改数据
     public function change()
     {
            $mpoverty = new MPoverty;
           $poverty = $mpoverty -> search(session("stuid"));
           $this->assign('poverty',$poverty);
     	return $this->fetch("change");
     }

     //输出数据到word文档
     public function printword()
     {
        $mpoverty = new MPoverty;
        $poverty = $mpoverty -> search(session("stuid"));
        if($poverty)
        {   
            //TemplateProcessor函数跟.doc的word文件不兼容！！！
           header('Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document');
           header('Content-Disposition: attachment;filename= application.docx');//告诉浏览器将输出文件的名称(文件下载)  
           header('Cache-Control: max-age=0');//禁止缓存  
            $PHPWord = new \PhpOffice\PhpWord\PhpWord(); 
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('D:\xampp2\htdocs\scholarship\public\static\index\word\poverty.docx');  
            foreach ($poverty as $key => $value) {
                $templateProcessor->setValue($key,$value ); 
            }

            $hukouA=$hukouB='□';
            if( $poverty["hukou"] == '城镇' ) {
                $hukouA = '■';
            } elseif( $poverty["hukou"] == '农村' ) {
                $hukouB = '■';
            } 
            $templateProcessor->setValue('hukouA',$hukouA); 
            $templateProcessor->setValue('hukouB',$hukouB); 
            
             $jdlkhA=$jdlkhB='□';
            if( $poverty["jdlkh"] == '是' ) {
                $jdlkhA = '■';
            } elseif( $poverty["jdlkh"] == '否' ) {
                $jdlkhB = '■';
            } 
            $templateProcessor->setValue('jdlkhA',$jdlkhA); 
            $templateProcessor->setValue('jdlkhB',$jdlkhB); 

             $gyryA=$gyryB='□';
            if( $poverty["gyry"] == '是' ) {
                $gyryA = '■';
            } elseif( $poverty["gyry"] == '否' ) {
                $gyryB = '■';
            } 
            $templateProcessor->setValue('gyryA',$gyryA); 
            $templateProcessor->setValue('gyryB',$gyryB); 

             $shbzhA=$shbzhB='□';
            if( $poverty["shbzh"] == '是' ) {
                $shbzhA = '■';
            } elseif( $poverty["shbzh"] == '否' ) {
                $shbzhB = '■';
            } 
            $templateProcessor->setValue('shbzhA',$shbzhA); 
            $templateProcessor->setValue('shbzhB',$shbzhB); 

             $zgznA=$zgznB='□';
            if( $poverty["zgzn"] == '是' ) {
                $zgznA = '■';
            } elseif( $poverty["zgzn"] == '否' ) {
                $zgznB = '■';
            } 
            $templateProcessor->setValue('zgznA',$zgznA); 
            $templateProcessor->setValue('zgznB',$zgznB); 

             $knjtA=$knjtB='□';
            if( $poverty["knjt"] == '是' ) {
                $knjtA = '■';
            } elseif( $poverty["knjt"] == '否' ) {
                $knjtB = '■';
            } 
            $templateProcessor->setValue('knjtA',$knjtA); 
            $templateProcessor->setValue('knjtB',$knjtB); 

             $guerA=$guerB='□';
            if( $poverty["guer"] == '是' ) {
                $guerA = '■';
            } elseif( $poverty["guer"] == '否' ) {
                $guerB = '■';
            } 
            $templateProcessor->setValue('guerA',$guerA); 
            $templateProcessor->setValue('guerB',$guerB); 

             $yffyA=$yffyB='□';
            if( $poverty["yffy"] == '是' ) {
                $yffyA = '■';
            } elseif( $poverty["yffy"] == '否' ) {
                $yffyB = '■';
            } 
            $templateProcessor->setValue('yffyA',$yffyA); 
            $templateProcessor->setValue('yffyB',$yffyB); 

             $lsznA=$lsznB='□';
            if( $poverty["lszn"] == '是' ) {
                $lsznA = '■';
            } elseif( $poverty["lszn"] == '否' ) {
                $lsznB = '■';
            } 
            $templateProcessor->setValue('lsznA',$lsznA); 
            $templateProcessor->setValue('lsznB',$lsznB); 

             $canjiA=$canjiB='□';
            if( $poverty["canji"] == '是' ) {
                $canjiA = '■';
            } elseif( $poverty["canji"] == '否' ) {
                $canjiB = '■';
            } 
            $templateProcessor->setValue('canjiA',$canjiA); 
            $templateProcessor->setValue('canjiB',$canjiB); 

             $hzdjbA=$hzdjbB='□';
            if( $poverty["hzdjb"] == '是' ) {
                $hzdjbA = '■';
            } elseif( $poverty["hzdjb"] == '否' ) {
                $hzdjbB = '■';
            } 
            $templateProcessor->setValue('hzdjbA',$hzdjbA); 
            $templateProcessor->setValue('hzdjbB',$hzdjbB); 

            $cjlbA=$cjlbB= $cjlbC=$cjlbD='□';
            if( $poverty["cjlb"] == '视残' ) {
                $cjlbA = '■';
            } elseif( $poverty["cjlb"] == '听残' ) {
                $cjlbB = '■';
            } elseif( $poverty["cjlb"] == '智残' ) {
                $cjlbC = '■';
            } elseif( $poverty["cjlb"] == '其他' ) {
                $cjlbD = '■';
            } 
            $templateProcessor->setValue('cjlbA',$cjlbA); 
            $templateProcessor->setValue('cjlbB',$cjlbB); 
            $templateProcessor->setValue('cjlbC',$cjlbC);
            $templateProcessor->setValue('cjlbD',$cjlbD);

             $cjdjA=$cjdjB= $cjdjC=$cjdjD='□';
            if( $poverty["cjdj"] == '一级' ) {
                $cjdjA = '■';
            } elseif( $poverty["cjdj"] == '二级' ) {
                $cjdjB = '■';
            } elseif( $poverty["cjdj"] == '三级' ) {
                $cjdjC = '■';
            } elseif( $poverty["cjdj"] == '四级' ) {
                $cjdjD = '■';
            } 
            $templateProcessor->setValue('cjdjA',$cjdjA); 
            $templateProcessor->setValue('cjdjB',$cjdjB); 
            $templateProcessor->setValue('cjdjC',$cjdjC);
            $templateProcessor->setValue('cjdjD',$cjdjD);

            $zfjqA=$zfjqB= $zfjqC='□';
            if( $poverty["zfjq"] == '自有' ) {
                $zfjqA = "■";
            } elseif( $poverty["zfjq"] == '租赁' ) {
                $zfjqB = "■";
            } elseif( $poverty["zfjq"] == '其他' ) {
                $zfjqC = "■";
            } 
            $templateProcessor->setValue('zfjqA',$zfjqA); 
            $templateProcessor->setValue('zfjqB',$zfjqB); 
            $templateProcessor->setValue('zfjqC',$zfjqC);

             $gcqkA=$gcqkB= $gcqkC=$gcqkD='□';
            if( $poverty["gcqk"] == '无车' ) {
                $gcqkA = '■';
            } elseif( $poverty["gcqk"] == '小轿车' ) {
                $gcqkB = '■';
            } elseif( $poverty["gcqk"] == '货车' ) {
                $gcqkC = '■';
            } elseif( $poverty["gcqk"] == '农机车' ) {
                $gcqkD = '■';
            } 
            $templateProcessor->setValue('gcqkA',$gcqkA); 
            $templateProcessor->setValue('gcqkB',$gcqkB); 
            $templateProcessor->setValue('gcqkC',$gcqkC);
            $templateProcessor->setValue('gcqkD',$gcqkD);    
                    
            $templateProcessor->saveAs('php://output');  
        }
     }
     
}
?>