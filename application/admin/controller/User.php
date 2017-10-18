<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\MUser;
use PHPExcel;
class User extends Controller
{

     public function _initialize()
     {
        if (!session('teaid'))
         {
                return $this->redirect('admin/Login/login');
         }
      }

    public function studentuser()
    {
      $muser = new MUser;
        $yuanxis = $muser -> tongji("studentuser","yuanxi");
        $banbies = $muser -> tongji("studentuser","banbie");
        $zhuanyes = $muser -> tongji("studentuser","zhuanye");
       $this -> assign('yuanxis',$yuanxis);   
        $this -> assign('banbies',$banbies);   
        $this -> assign('zhuanyes',$zhuanyes);   
    	return $this -> fetch("studentuser");
    }

    //遍历所有的学生账号输出到iframe
    public function studentshow()
    {
    	     $muser = new MUser;
        	$list = $muser -> getalluser("studentuser","stuid");
         	$page = $list->render();
              // 模板变量赋值
              $this->assign('list', $list);
              $this->assign('page', $page);
              // 渲染模板输出
              return $this->fetch();
    }

    //查询某个学生
    public function checkstudent()
    {
            $usertype = $_GET["usertype"];
            $username = $_GET["username"];
            $muser = new MUser;
            $list = $muser -> getuserid("studentuser",$usertype,$username);
            $page = $list->render();
            $this -> assign('list',$list);           
            $this->assign('page', $page); 
            return $this -> fetch("studentshow");
    }

    //添加一个学生
    public function addstudent()
    {
    	if(request() -> isPost())    //验证表单提交的账户和密码
            {
                   $muser = new MUser;
                        $muser -> adduserid("studentuser",$_POST);
                        echo "<script>alert('添加成功!');window.location.href= 'studentuser';</script>";
             }
            else
             {
                    return $this->fetch("studentuser");
             }
    }

    //删除某个学生id
    public function deletestudent()
    {
          $usertype = $_GET["usertype"];
          $user = $_GET["username"];
          $muser = new MUser;
          $users = $muser -> deleteuserid("studentuser",$usertype,$user);
          echo "<script>alert('删除成功!');location.href='studentshow';</script>";
    }

        public function checkall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
         $zhuanye = $_GET['zhuanye'];
        $xuejihao = $_GET['xuejihao'];
        $mlist = new MUser;
        $list = $mlist -> checkall($yuanxi,$banbie,$xuejihao,$zhuanye);
        $page = $list->render();
        $this -> assign('list',$list);           
        $this->assign('page', $page); 
        return $this -> fetch("studentshow");
    }

    public function deleteall()
    {
        $yuanxi = $_GET['yuanxi'];
        $banbie = $_GET['banbie'];
         $zhuanye = $_GET['zhuanye'];
        $xuejihao = $_GET['xuejihao'];
        $mlist = new MUser;
        $list = $mlist -> deleteall($yuanxi,$banbie,$xuejihao,$zhuanye);
        echo "<script>alert('删除成功!');</script>";
    }

    //清空所有学生
    public function deleteallstudent()
    {
          $muser = new MUser;
          $users = $muser -> deletealluser("studentuser");
          echo "<script>alert('清空成功!');location.href='studentuser';</script>";
    }
    
      //批量导入学生
     public function pushcsvstudent()
      {
            $filename = $_FILES['file']['tmp_name']; 
            if (empty ($filename)) { 
            echo '请选择要导入的CSV文件！'; 
            exit; 
            }
            else{
                    $handle = fopen($filename, 'r'); 
                      $muser = new MUser;
                    $result = $muser -> input_csv($handle); //解析csv 
                    $len_result = count($result); 
                    if($len_result==0){ 
                        echo '没有任何数据！'; 
                        exit; 
                      }      
                    for ($i = 1; $i < $len_result; $i++) { //循环一条条导入数据库
                            $inf = [
                                   'stuid' => $result[$i][0],
                                   'xuejihao' => $result[$i][0],
                                   'password' => $result[$i][1],
                                   'xingming' => $result[$i][2],
                                   'xingbie' => $result[$i][3],
                                   'yuanxi' => $result[$i][4],
                                   'banbie' => $result[$i][5],
                                   'sfzh' => $result[$i][6],
                                   'zhuanye' => $result[$i][7],
                                   ];
                             $muser -> adduserid("studentuser",$inf);   
                             $inf2 = [
                                   'stuid' => $result[$i][0],
                                   'xuejihao' => $result[$i][0],
                                   'xingming' => $result[$i][2],
                                   'xingbie' => $result[$i][3],
                                   'yuanxi' => $result[$i][4],
                                   'banbie' => $result[$i][5],
                                   'sfzh' => $result[$i][6],
                                   'zhuanye' => $result[$i][7],
                                   ];
                             $muser -> adduserid("poverty",$inf2);   
                              $inf3 = [
                                   'stuid' => $result[$i][0],
                                   'xuejihao' => $result[$i][0],
                                   'xingming' => $result[$i][2],
                                   'yuanxi' => $result[$i][4],
                                   'banbie' => $result[$i][5],
                                   'zhuanye' => $result[$i][7],
                                   ];
                             $muser -> adduserid("povertysl",$inf3);   
                       } 
                             echo "<script>alert('添加成功!');window.location.href= 'studentuser';</script>"; 
            }
      }

      //导入模板下载
      public function studentsdemo()
      {
        $filename = 'studentdemo.xls';
                $objPHPExcel = new PHPExcel;
                $objPHPExcel->createSheet();        
                $objPHPExcel->setActiveSheetIndex();//把当前创建的sheet设置为活动sheet  
                $objSheet = $objPHPExcel->getActiveSheet();//获得当前活动Sheet  
                $objSheet->setTitle("demo");  //写标题
                $objSheet->setCellValue('A1','学号（例：3115001234）')
                                ->setCellValue('B1','初始密码（例：123456）')
                                ->setCellValue('C1','姓名')
                                ->setCellValue('D1','性别')
                                ->setCellValue('E1','学院')  
                                ->setCellValue('F1','班别')
                                ->setCellValue('G1','身份证号')
                                ->setCellValue('H1','专业');
                                        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
                                        header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件  
                                        header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器将输出文件的名称(文件下载)  
                                        header('Cache-Control: max-age=0');//禁止缓存  
                                        $objWriter->save("php://output");  
      }

            public function tongji()
      {
             $muser = new MUser;
             $result = $muser -> tonji("studentuser","yuanxi");
             var_dump($result);
      }








        public function teacheruser()
    {
      return $this -> fetch("teacheruser");
    }

    //遍历所有的老师账号输出到iframe
    public function teachershow()
    {
           $muser = new MUser;
          $list = $muser -> getalluser("teacheruser","id");
          $page = $list->render();
              // 模板变量赋值
              $this->assign('list', $list);
              $this->assign('page', $page);
              // 渲染模板输出
              return $this->fetch();
    }

    //查询某个老师
    public function checkteacher()
    {
            $usertype = $_GET["usertype"];
            $username = $_GET["username"];
            $muser = new MUser;
            $users = $muser -> getuserid("teacheruser",$usertype,$username);
            $this -> assign('users',$users);            
            return $this -> fetch("teachershow");
    }

    //添加或更新一个老师
    public function addteacher()
    {
      if(request() -> isGet())    //验证表单提交的账户和密码
            {

                   $muser = new MUser;
                   $teaid = $_GET["teaid"];
                        $inf = [
                                   'teaid' => $_GET["teaid"],
                                   'password' => $_GET["password"],
                                   'yuanxi' => $_GET["yuanxi"]
                                   ];
                        $muser -> adduserid("teacheruser",$inf);
                        echo "<script>alert('添加成功!');window.location.href= 'teacheruser';</script>";
                   }
            else
             {
                    return $this->fetch("teacheruser");
             }
    }

    //删除某个老师id
    public function deleteteacher()
    {
          $usertype = $_GET["usertype"];
          $user = $_GET["username"];
          $muser = new MUser;
          $users = $muser -> deleteuserid("teacheruser",$usertype,$user);
          echo "<script>alert('删除成功!');location.href='teachershow';</script>";
    }

    //清空所有老师
    public function deleteallteacher()
    {
          $muser = new MUser;
          $users = $muser -> deletealluser("teacheruser");
          echo "<script>alert('清空成功!');location.href='teacheruser';</script>";
    }
    
      //批量导入老师
      public function pushcsvteacher()
      {
            $filename = $_FILES['file']['tmp_name']; 
            if (empty ($filename)) { 
            echo '请选择要导入的CSV文件！'; 
            exit; 
            }
            else{
                    $handle = fopen($filename, 'r'); 
                    $muser = new MUser;
                    $result = $muser -> input_csv($handle); //解析csv 
                    $len_result = count($result); 
                    if($len_result==0){ 
                        echo '没有任何数据！'; 
                        exit; 
                      }      
                    for ($i = 1; $i < $len_result; $i++) { //循环一条条导入数据库
                            $inf = [
                                   'teaid' => $result[$i][0],
                                   'password' => $result[$i][1],
                                   'yuanxi' => $result[$i][2]
                                   ];
                             $muser -> adduserid("teacheruser",$inf);   
                       } 
                             echo "<script>alert('添加成功!');window.location.href= 'teacheruser';</script>"; 
            }
      }

      //导入模板下载
      public function teachersdemo()
      {
        $filename = 'teacherdemo.xls';
                $objPHPExcel = new PHPExcel;
                $objPHPExcel->createSheet();        
                $objPHPExcel->setActiveSheetIndex();//把当前创建的sheet设置为活动sheet  
                $objSheet = $objPHPExcel->getActiveSheet();//获得当前活动Sheet  
                $objSheet->setTitle("demo");  //写标题
                $objSheet->setCellValue('A1','教工号')
                                ->setCellValue('B1','密码（123456）')
                                ->setCellValue('C1','学院');
                                        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
                                        header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件  
                                        header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器将输出文件的名称(文件下载)  
                                        header('Cache-Control: max-age=0');//禁止缓存  
                                        $objWriter->save("php://output");  
      }

}
