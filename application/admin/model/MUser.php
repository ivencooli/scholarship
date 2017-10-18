<?php
namespace app\admin\model;
use think\Model;
use think\Session;
use think\Db;

class MUser extends Model
{   
    //数据库查询所有数据集
      public function getalluser($usertable,$usertype)
      {
       //$users = Db::table($usertable)->where([$usertype  =>  ['>',0] ]) ->select();
        $list = Db::name($usertable)->where([$usertype => array('neq','')])->paginate(15);
       return $list;
      }

      //数据库清除所有值
      public function deletealluser($usertable)
      {
       Db::table($usertable)->where('id','>',0)->delete();
      }

        public function checkall($yuanxi,$banbie,$xuejihao,$zhuanye)
      {
        if($yuanxi == "notype"){$yuanxi = array('neq','');}
        if($banbie == "notype"){$banbie = array('neq','');}
        if($xuejihao == "notype"){$xuejihao = array('neq','');}
        if($zhuanye == "notype"){$zhuanye = array('neq','');}
       $users = Db::table('studentuser')->where(["yuanxi"=> $yuanxi , "banbie"=> $banbie , "xuejihao"=> $xuejihao ,"zhuanye"=> $zhuanye]) ->paginate(15,false,
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
       Db::table('studentuser')->where(["yuanxi"=> $yuanxi , "banbie"=> $banbie , "xuejihao"=> $xuejihao ,"zhuanye"=> $zhuanye]) ->delete();
      }


      //数据库查询某个id
        public function getuserid($usertable,$usertype,$userid)
      {
       $user = Db::table($usertable)->where([$usertype => $userid]) ->paginate(15,false,
                                                                                                                        ["query" => ["usertype" =>$usertype,"username" =>$userid]
                                                                                                                        ]);
       return $user;
      }

      //数据库添加某个id
      public function adduserid($usertable,$info)
      {
        Db::table($usertable) ->insert($info);
      }

      //数据库更新某个id
      public function updateuserid($usertable,$usertype,$user,$info)
      {
        Db::table($usertable)->where($usertype,$user)->update($info);
      }

      //数据库删除某个id
      public function deleteuserid($usertable,$usertype,$user)
      {
          Db::table($usertable)->where($usertype,$user)->delete();
      }



      public   function input_csv($handle) 
      { 
          $out = array (); 
           $n = 0; 
           while ($data = fgetcsv($handle, 10000)) 
           { 
                $num = count($data); 
                for ($i = 0; $i < $num; $i++) 
                { 
                    $out[$n][$i] = $data[$i]; 
                 } 
                 $n++; 
           } 
           return $out; 
      } 

      public function tongji($usertable,$usertype)
      {
          return Db::table($usertable)->distinct(true)->field($usertype)->select();
      }

 }
 ?>