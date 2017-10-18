<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\MSumconsch;
use PHPExcel;       
class Sumconsch extends Controller
{
//检测到未登录进行重新登录
     public function _initialize()
     {
        if (!session('teaid'))
         {
                return $this->redirect('admin/Login/login');
         }
      }

    public function page()
    {
        return $this->fetch('searchlist');
    }
    //输出所有学生
        public function showall()
    {
            $muser = new MSumconsch;
            $sumconsch = $muser -> getalluser("stuid");
            $this -> assign('sumconsch',$sumconsch);            
            return $this -> fetch("show");
    }

    //搜索班级，姓名，学号
    public function searchall()
    {
        $searchtype = $_GET['searchtype'];
        $searchid =  $_GET['searchid'];
        $msumconsch = new MSumconsch;
        $sumconsch = $msumconsch -> search($searchtype,$searchid);
         $this -> assign('sumconsch',$sumconsch);            
         return $this -> fetch("show");
    }

         public function checkall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
        $xuejihao = $_GET['xuejihao'];
        $msumconsch = new MSumconsch;
        $sumconsch = $msumconsch -> checkall($yuanxi,$banbie,$xuejihao);
        $this -> assign('sumconsch',$sumconsch);            
        return $this -> fetch("show");
    }

    public function deleteall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
        $xuejihao = $_GET['xuejihao'];
        $msumconsch = new MSumconsch;
        $sumconsch = $msumconsch -> deleteall($yuanxi,$banbie,$xuejihao);
        echo "<script>alert('删除成功!');</script>";
    }

    //查看学生信息
    public function checkstu()
    {
        $stuid = $_GET['stuid'];
        $msumconsch = new MSumconsch;
        $sumconsch = $msumconsch -> searchstu($stuid);
        $this -> assign('sumconsch',$sumconsch);            
        return $this -> fetch("checkstu");
    }
    //修改学生信息
     public function changestu()
    {
        $stuid = $_GET['stuid'];
        $changetype = $_GET['changetype'];
        $changename = $_GET['changename'];
        $msumconsch = new MSumconsch;
        $msumconsch -> updatestu($stuid,$changetype,$changename);
        echo "<script>alert('修改成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";//利用js重新刷新
    }
    //删除学生信息
    public function deletestu()
    {
        $stuid = $_GET['stuid'];
        $msumconsch = new MSumconsch;
        $sumconsch = $msumconsch -> deletestu($stuid);
        echo "<script>alert('删除成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";//利用js重新刷新
    }

        public function abc(){  
        //ajax传值测试  
            $arr = $_GET['stuname']."ajax传值测试  ";
            return $arr;
    }      

    public function outexcel()
    {
       $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
        $xuejihao = $_GET['xuejihao'];
        $msumconsch = new MSumconsch;
        $sumconsch = $msumconsch -> checkall($yuanxi,$banbie,$xuejihao);
        $this -> assign('sumconsch',$sumconsch);       
        $filename = 'scholarship.xls';
                $objPHPExcel = new PHPExcel;
                $objPHPExcel->createSheet();        
                $objPHPExcel->setActiveSheetIndex();//把当前创建的sheet设置为活动sheet  
                $objSheet = $objPHPExcel->getActiveSheet();//获得当前活动Sheet  
                $objSheet->setTitle("demo");  //写标题
                $objPHPExcel->getActiveSheet()->mergeCells('A1:M1'); 
                $objSheet->setCellValue('A1','  2015  - 2016学年度广东省普通高校本专科生国家奖学金获奖学生初审名单表                                             ');
                 $objPHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->setSize(20);  
                 $objPHPExcel->getActiveSheet()->mergeCells('A2:C2'); 
                 $objSheet->setCellValue('A2','学校名称（公章）： ');
                 $objPHPExcel->getActiveSheet()->getStyle( 'A2')->getFont()->setSize(14);  
                 $objPHPExcel->getActiveSheet()->mergeCells('I2:M2'); 
                 $objSheet->setCellValue('I2','填表日期：    年   月   日 ');
                 $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setSize(14); 
                 $objPHPExcel->getActiveSheet()->mergeCells('A3:A4'); 
                 $objSheet->setCellValue('A3','序号');
                 $objPHPExcel->getActiveSheet()->mergeCells('B3:B4'); 
                 $objSheet->setCellValue('B3','学生姓名');
                 $objPHPExcel->getActiveSheet()->mergeCells('C3:C4'); 
                 $objSheet->setCellValue('C3','公民身份证号码');
                 $objPHPExcel->getActiveSheet()->mergeCells('D3:D4'); 
                 $objSheet->setCellValue('D3','院系');
                 $objPHPExcel->getActiveSheet()->mergeCells('E3:E4'); 
                 $objSheet->setCellValue('E3','专业');
                 $objPHPExcel->getActiveSheet()->mergeCells('F3:F4'); 
                 $objSheet->setCellValue('F3','学号');
                 $objPHPExcel->getActiveSheet()->mergeCells('G3:G4'); 
                 $objSheet->setCellValue('G3','性别');
                 $objPHPExcel->getActiveSheet()->mergeCells('H3:H4'); 
                 $objSheet->setCellValue('H3','民族');
                 $objPHPExcel->getActiveSheet()->mergeCells('I3:I4'); 
                 $objSheet->setCellValue('I3','入学年月');
                 $objPHPExcel->getActiveSheet()->mergeCells('J3:K3'); 
                 $objSheet->setCellValue('J3','成绩排名');
                 $objPHPExcel->getActiveSheet()->mergeCells('L3:M3'); 
                 $objSheet->setCellValue('L3','综合考评排名');
                 $objSheet->setCellValue('J4','名次');
                 $objSheet->setCellValue('K4','总人数');
                 $objSheet->setCellValue('L4','名次');               
                 $objSheet->setCellValue('M4','总人数');
                 $i = 1;$j = 5;
                foreach ($sumconsch as $key => $value) {  
                        $objSheet->setCellValue('A'.$j,$i)
                                        ->setCellValue('B'.$j,$value['xingming'])
                                        ->setCellValue('C'.$j,$value['sfzh'])
                                        ->setCellValue('D'.$j,$value['yuanxi'])
                                        ->setCellValue('E'.$j,$value['zhuanye'])
                                        ->setCellValue('F'.$j,$value['xuejihao'])
                                        ->setCellValue('G'.$j,$value['xingbie'])
                                        ->setCellValue('H'.$j,$value['minzu'])
                                        ->setCellValue('I'.$j,$value['rxny'])
                                        ->setCellValue('J'.$j,$value['cjpmmc'])
                                        ->setCellValue('K'.$j,$value['cjpmzrs'])
                                        ->setCellValue('L'.$j,$value['zhkpmc'])
                                        ->setCellValue('M'.$j,$value['zhkpzrs']);
                                        $i += 1;
                                        $j += 1;
                }
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$j.':M'.$j); 
                $objSheet->setCellValue('A'.$j,'注：1.学年度为上一学年；2.没有实行综合考评的学校不填综合考评排名。');
                 $objPHPExcel->getActiveSheet()->getStyle('A'.$j)->getFont()->setSize(10);  
                 $objPHPExcel->getActiveSheet()->mergeCells('A'.($j+1).':M'.($j+1)); 
                $objSheet->setCellValue('A'.($j+1),'经办人：                        联系电话：                         传真：                   电子邮箱： ');
                 $objPHPExcel->getActiveSheet()->getStyle('A'.($j+1))->getFont()->setSize(14);  
/*
                                ->setCellValue('B1','年级')
                                ->setCellValue('C1','班别（专业）')
                                ->setCellValue('D1','院（系）')  
                                ->setCellValue('E1','宿舍')
                                ->setCellValue('F1','学（籍）号')
                                ->setCellValue('G1','姓名')
                                ->setCellValue('H1','性别')
                                ->setCellValue('I1','民族')
                                ->setCellValue('J1','出生年月') 
                                ->setCellValue('K1','身份证号')
                                ->setCellValue('L1','户口')
                                ->setCellValue('M1','家庭人口数')
                                ->setCellValue('N1','家庭成员在学人数')
                                ->setCellValue('O1','建档立卡户')
                                ->setCellValue('P1','特困供养人员')
                                ->setCellValue('Q1','城乡最低生活保障户')
                                ->setCellValue('R1','特困职工子女')
                                ->setCellValue('S1','城镇低收入困难家庭')
                                ->setCellValue('T1','孤儿')
                                ->setCellValue('U1','父母一方抚养')
                                ->setCellValue('V1','烈士子女、因公牺牲军人警察子女')
                                ->setCellValue('W1','残疾')
                                ->setCellValue('X1','患重大疾病')
                                ->setCellValue('Y1','残疾类别')
                                ->setCellValue('Z1','残疾等级');
                $j = 2; foreach ($sumconsch as $key => $value) {  
                                     $objSheet->setCellValue('A'.$j,$value['xuexiao'])
                                                    ->setCellValue('B'.$j,$value['nianji'])
                                                    ->setCellValue('C'.$j,$value['banbie'])
                                                    ->setCellValue('D'.$j,$value['yuanxi'])  
                                                    ->setCellValue('E'.$j,$value['sushe'])
                                                    ->setCellValue('F'.$j,$value['xuejihao'])
                                                    ->setCellValue('G'.$j,$value['xingming'])
                                                    ->setCellValue('H'.$j,$value['xingbie'])
                                                    ->setCellValue('I'.$j,$value['minzu'])
                                                    ->setCellValue('J'.$j,$value['csny'])
                                                    ->setCellValue('K'.$j,$value['sfzh'])  
                                                    ->setCellValue('L'.$j,$value['hukou'])
                                                    ->setCellValue('M'.$j,$value['jtrks'])
                                                    ->setCellValue('N'.$j,$value['zxrs'])
                                                    ->setCellValue('O'.$j,$value['jdlkh']) 
                                                    ->setCellValue('P'.$j,$value['gyry'])
                                                    ->setCellValue('Q'.$j,$value['shbzh'])
                                                    ->setCellValue('R'.$j,$value['zgzn'])  
                                                    ->setCellValue('S'.$j,$value['knjt'])
                                                    ->setCellValue('T'.$j,$value['guer'])
                                                    ->setCellValue('U'.$j,$value['yffy'])
                                                    ->setCellValue('V'.$j,$value['lszn'])
                                                    ->setCellValue('W'.$j,$value['canji'])
                                                    ->setCellValue('X'.$j,$value['hzdjb'])
                                                    ->setCellValue('Y'.$j,$value['cjlb'].$value['cjlbtext'])
                                                    ->setCellValue('Z'.$j,$value['cjdj']);
                                                    $j++; 
                                }                                     
                                */                      
                                        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
                                        header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件  
                                        header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器将输出文件的名称(文件下载)  
                                        header('Cache-Control: max-age=0');//禁止缓存  
                                        $objWriter->save("php://output");  
    }

}

?>