<?php
namespace app\admin\model;
use think\Model;
use think\Session;
use think\Db;

class MPoverty extends Model
{   
  //==============================================================
    //数据库查询所有数据集
      public function getalluser($usertype)
      {
       $users = Db::table('poverty')->where([$usertype=>array('neq','')])->paginate(15);
       return $users;
      }

      public function checkall($yuanxi,$banbie,$xuejihao,$zhuanye)
      {
        if($yuanxi == "notype"){$yuanxi = array('neq','');}
        if($banbie == "notype"){$banbie = array('neq','');}
        if($xuejihao == "notype"){$xuejihao = array('neq','');}
        if($zhuanye == "notype"){$zhuanye = array('neq','');}
       $users = Db::table('poverty')->where(["yuanxi"=> $yuanxi , "banbie"=> $banbie , "xuejihao"=> $xuejihao ,"zhuanye"=> $zhuanye]) ->paginate(15,false,
                                                                                                                        ["query" => ["yuanxi" =>$yuanxi,"banbie" =>$banbie,"xuejihao" =>$xuejihao,"zhuanye" =>$zhuanye]
                                                                                                                        ]);
       return $users;
      }

      public function deleteall($yuanxi,$banbie,$xuejihao,$zhuanye)
      {
        if($yuanxi == "notype"){$yuanxi = array('neq','');}
        if($banbie == "notype"){$banbie = array('neq','');}
        if($xuejihao == "notype"){$xuejihao = array('neq','');}
        if($zhuanye == "notype"){$zhuanye = array('neq','');}
       Db::table('poverty')->where(["yuanxi"=> $yuanxi , "banbie"=> $banbie , "xuejihao"=> $xuejihao ,"zhuanye"=> $zhuanye]) ->delete();
      }

//================================================================
        //数据库查询学生具体信息
        public function searchstu($stuid)
        {
        	$stu = Db::table('poverty')->where('stuid',$stuid)->find(); // 获取数据集
        	return $stu;
        }

        //数据库删除学生具体信息
        public function deletestu($stuid)
        {
        	Db::table('poverty')->where('stuid',$stuid)->delete();
        }

         public function tongji($usertable,$usertype)
      {
          return Db::table($usertable)->distinct(true)->field($usertype)->select();
      }

 //===================================================================       
        //数据库更新学生信息
        public function updatestu($stuid,$type,$name)
        {
          Db::table('poverty') ->where('stuid',$stuid) ->update([$type => $name]);
        }
 }
 ?>