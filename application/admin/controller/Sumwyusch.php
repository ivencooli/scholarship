<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\MSumwyusch;
use PHPExcel;       
class Sumwyusch extends Controller
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
            $muser = new MSumwyusch;
            $sumwyusch = $muser -> getalluser("stuid");
            $this -> assign('sumwyusch',$sumwyusch);            
            return $this -> fetch("show");
    }

    //搜索班级，姓名，学号
    public function searchall()
    {
        $searchtype = $_GET['searchtype'];
        $searchid =  $_GET['searchid'];
        $msumwyusch = new MSumwyusch;
        $sumwyusch = $msumwyusch -> search($searchtype,$searchid);
         $this -> assign('sumwyusch',$sumwyusch);            
         return $this -> fetch("show");
    }

         public function checkall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
        $xuejihao = $_GET['xuejihao'];
        $msumwyusch = new MSumwyusch;
        $sumwyusch = $msumwyusch -> checkall($yuanxi,$banbie,$xuejihao);
        $this -> assign('sumwyusch',$sumwyusch);            
        return $this -> fetch("show");
    }

    public function deleteall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
        $xuejihao = $_GET['xuejihao'];
        $msumwyusch = new MSumwyusch;
        $sumwyusch = $msumwyusch -> deleteall($yuanxi,$banbie,$xuejihao);
        echo "<script>alert('删除成功!');</script>";
    }

    //查看学生信息
    public function checkstu()
    {
        $stuid = $_GET['stuid'];
        $msumwyusch = new MSumwyusch;
        $sumwyusch = $msumwyusch -> searchstu($stuid);
        $this -> assign('sumwyusch',$sumwyusch);            
        return $this -> fetch("checkstu");
    }


    //修改学生信息
     public function changestu()
    {
        $stuid = $_GET['stuid'];
        $changetype = $_GET['changetype'];
        $changename = $_GET['changename'];
        $msumwyusch = new MSumwyusch;
        $msumwyusch -> updatestu($stuid,$changetype,$changename);
        echo "<script>alert('修改成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";//利用js重新刷新
    }
    //删除学生信息
    public function deletestu()
    {
        $stuid = $_GET['stuid'];
        $msumwyusch = new MSumwyusch;
        $sumwyusch = $msumwyusch -> deletestu($stuid);
        echo "<script>alert('删除成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";//利用js重新刷新
    }

    public function outexcel()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
        $xuejihao = $_GET['xuejihao'];
        $msumwyusch = new MSumwyusch;
        $sumwyusch = $msumwyusch -> checkall($yuanxi,$banbie,$xuejihao);
        $this -> assign('sumwyusch',$sumwyusch);       
        $filename = 'wyuscholarship.xls';
                $objPHPExcel = new PHPExcel;
                $objPHPExcel->createSheet();        
                $objPHPExcel->setActiveSheetIndex();//把当前创建的sheet设置为活动sheet  
                $objSheet = $objPHPExcel->getActiveSheet();//获得当前活动Sheet  
                $objSheet->setTitle("demo");  //写标题
                $objPHPExcel->getActiveSheet()->mergeCells('A1:J1'); 
                $objSheet->setCellValue('A1',$yuanxi.'学院奖学金汇总表');
                 $objPHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->setSize(20);  
                 $objPHPExcel->getActiveSheet()->mergeCells('A2:J2'); 
                 $objSheet->setCellValue('A2','                                 　　　　　　　　　　　　　    年        月      日');
                 $objPHPExcel->getActiveSheet()->getStyle( 'A2')->getFont()->setSize(11);  
                 $objSheet->setCellValue('A3','序号');
                 $objSheet->setCellValue('B3','班级中文简称');
                 $objSheet->setCellValue('C3','学号');
                 $objSheet->setCellValue('D3','姓名');               
                 $objSheet->setCellValue('E3','性别');
                 $objSheet->setCellValue('F3','荣誉称号（校级“优秀三好学生”/校级“三好学生”/院级“三好学生”）');
                 $objSheet->setCellValue('G3','等级(一等奖/二等奖/三等奖)');
                 $objSheet->setCellValue('H3','政治面貌(中共党员、中共预备党员、共青团员、群众）');
                 $objSheet->setCellValue('I3','2015-2016学年度其他获奖项目（指国家奖学金、国家励志奖学金、伍舜德精神奖、黄炳礼史带奖学金）');               
                 $objSheet->setCellValue('J3','2015-2016学年度获得过哪些助学金（可多填）');     
                 $i = 1;$j = 4;
                foreach ($sumwyusch as $key => $value) {  
                        $objSheet->setCellValue('A'.$j,$i)
                                        ->setCellValue('B'.$j,$value['banbie'])
                                        ->setCellValue('C'.$j,$value['xuejihao'])
                                        ->setCellValue('D'.$j,$value['xingming'])
                                        ->setCellValue('E'.$j,$value['xingbie'])
                                        ->setCellValue('F'.$j,$value['rych'])
                                        ->setCellValue('G'.$j,$value['dengji'])
                                        ->setCellValue('H'.$j,$value['zzmm'])
                                        ->setCellValue('I'.$j,$value['qthjxm'])
                                        ->setCellValue('J'.$j,$value['zhuxuejin']);
                                        $i += 1;
                                        $j += 1;
                }
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$j.':J'.$j); 
                $objSheet->setCellValue('A'.$j,'辅导员老师：                                                                                 学生工作负责人：                                              ');
                 $objPHPExcel->getActiveSheet()->getStyle('A'.$j)->getFont()->setSize(12);  
                 $objPHPExcel->getActiveSheet()->mergeCells('A'.($j+2).':J'.($j+2)); 
                $objSheet->setCellValue('A'.($j+2),'                                                                                              请签名盖学院公章 ');
                 $objPHPExcel->getActiveSheet()->getStyle('A'.($j+2))->getFont()->setSize(12);      
                
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
                $j = 2; foreach ($sumwyusch as $key => $value) {  
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