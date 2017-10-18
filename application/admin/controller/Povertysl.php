<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\MPovertysl;
use app\admin\model\MPhpexcel;
use PHPExcel;       
class Povertysl extends Controller
{
//检测到未登录进行重新登录
     public function _initialize()
     {
        if (!session('teaid'))
         {
                return $this->redirect('admin/Login/login');
         }
      }

//=================================搜索列页面====================================
    public function page()
    {
        $muser = new MPovertysl;
        $yuanxis = $muser -> tongji("studentuser","yuanxi");
        $banbies = $muser -> tongji("studentuser","banbie");
        $zhuanyes = $muser -> tongji("studentuser","zhuanye");
       $this -> assign('yuanxis',$yuanxis);   
        $this -> assign('banbies',$banbies);   
        $this -> assign('zhuanyes',$zhuanyes);   
        return $this->fetch('searchlist');
          //  var_dump($yuanxis);
    }
    //输出所有学生
        public function showall()
    {
            $muser = new MPovertysl;
            $povertysl = $muser -> getalluser("stuid");
            $page = $povertysl->render();
              // 模板变量赋值
            $this -> assign('povertysl',$povertysl);
              $this->assign('page', $page);            
            return $this -> fetch("showlist");
    }

     public function checkall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
         $zhuanye = $_GET['zhuanye'];
        $xuejihao = $_GET['xuejihao'];
        $mpovertysl = new MPovertysl;
        $povertysl = $mpovertysl -> checkall($yuanxi,$banbie,$xuejihao,$zhuanye);
         $page = $povertysl->render();
    // 模板变量赋值
        $this -> assign('povertysl',$povertysl);
        $this->assign('page', $page);       
         return $this -> fetch("showlist");
        //echo $yuanxi.$banbie.$zhuanye.$xuejihao;
    }

    public function deleteall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
         $zhuanye = $_GET['zhuanye'];
        $xuejihao = $_GET['xuejihao'];
        $mpovertysl = new MPovertysl;
        $povertysl = $mpovertysl -> deleteall($yuanxi,$banbie,$xuejihao,$zhuanye);
        echo "<script>alert('删除成功!');</script>";
    }

    public function outexcel()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
        $zhuanye = $_GET['zhuanye'];
        $xuejihao = $_GET['xuejihao'];
        $mpovertysl = new MPovertysl;
        $povertysl = $mpovertysl -> checkall($yuanxi,$banbie,$xuejihao,$zhuanye);
        $this -> assign('povertysl',$povertysl);       
        $filename = $banbie.'.xls';
                $objPHPExcel = new PHPExcel;
                $objPHPExcel->createSheet();        
                $objPHPExcel->setActiveSheetIndex();//把当前创建的sheet设置为活动sheet  
                $objSheet = $objPHPExcel->getActiveSheet();//获得当前活动Sheet  
                $objSheet->setTitle("demo");  //写标题
                $objSheet->setCellValue('A1','学校')
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
                $j = 2; foreach ($povertysl as $key => $value) {  
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
                                        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
                                        header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件  
                                        header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器将输出文件的名称(文件下载)  
                                        header('Cache-Control: max-age=0');//禁止缓存  
                                        $objWriter->save("php://output");  
    }

    
//===================================罗列学生信息页面============================
    //查看学生信息
    public function checkstu()
    {
        $stuid = $_GET['stuid'];
        $mpovertysl = new MPovertysl;
        $povertysl = $mpovertysl -> searchstu($stuid);
        $this -> assign('povertysl',$povertysl);            
        return $this -> fetch("checkstu");
    }
    //删除学生信息
    public function deletestu()
    {
        $stuid = $_GET['stuid'];
        $mpovertysl = new MPovertysl;
        $povertysl = $mpovertysl -> deletestu($stuid);
        echo "<script>alert('删除成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";//利用js重新刷新
    }

//====================================修改学生页面===================================
    //修改学生信息
     public function changestu()
    {
        $stuid = $_GET['stuid'];
        $changetype = $_GET['changetype'];
        $changename = $_GET['changename'];
        $mpovertysl = new MPovertysl;
        $mpovertysl -> updatestu($stuid,$changetype,$changename);
        echo "<script>alert('修改成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";//利用js重新刷新
    }

    public function printexcel()
    {
            $stuid = $_GET['stuid'];
            $mpovertysl = new MPovertysl;
            $povertysl = $mpovertysl -> searchstu($stuid);
            $p = new MPhpexcel('D:\xampp2\htdocs\scholarship\public\static\index\excel\povertysl.xls');
            $p->add_data($povertysl);
            $p->output('povertysl.xls');
    }

}

?>