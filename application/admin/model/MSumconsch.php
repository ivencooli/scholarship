<?php
namespace app\admin\model;
use think\Model;
use think\Session;
use think\Db;

class MSumconsch extends Model
{   
    //数据库查询所有数据集
      public function getalluser($usertype)
      {
       $users = Db::table('sumconsch')->where(['stuid'=>array('neq','')]) ->select();
       return $users;
      }

      public function checkall($yuanxi,$banbie,$xuejihao)
      {
        if($yuanxi == "notype"){$yuanxi = array('neq','');}
        if($banbie == "notype"){$banbie = array('neq','');}
        if($xuejihao == "notype"){$xuejihao = array('neq','');}
       $users = Db::table('sumconsch')->where(["yuanxi"=> $yuanxi , "banbie"=> $banbie , "xuejihao"=> $xuejihao ]) ->select();
       return $users;
      }

      public function deleteall($yuanxi,$banbie,$xuejihao)
      {
        if($yuanxi == "notype"){$yuanxi = array('neq','');}
        if($banbie == "notype"){$banbie = array('neq','');}
        if($xuejihao == "notype"){$xuejihao = array('neq','');}
       Db::table('sumconsch')->where(["yuanxi"=> $yuanxi , "banbie"=> $banbie , "xuejihao"=> $xuejihao ]) ->delete();
      }

        //数据库查询班级，名称，学籍号
        public function search($searchtype,$searchid)
        {
            $stus = Db::table('sumconsch')->where($searchtype,$searchid)->select(); // 获取数据集
             return  $stus;
        }

        //数据库查询学生具体信息
        public function searchstu($stuid)
        {
          $stu = Db::table('sumconsch')->where('stuid',$stuid)->find(); // 获取数据集
          return $stu;
        }

        //数据库更新学生信息
        public function updatestu($stuid,$type,$name)
        {
          Db::table('sumconsch') ->where('stuid',$stuid) ->update([$type => $name]);
        }

        //数据库删除学生具体信息
        public function deletestu($stuid)
        {
          Db::table('sumconsch')->where('stuid',$stuid)->delete();
        }

        //数据库打印数据
        public function printexcel()
        {
             $users = Db::table('sumconsch')->where(["id"  =>  ['>',0] ]) ->select();
              return $users;
        }
        
 }
 ?>