<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MWyuadvancedclass extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $wyuadvancedclass = Db::name('wyuadvancedclass') -> where('stuid','=',$stuid)-> find();
        return $wyuadvancedclass;
     }

     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('wyuadvancedclass') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('wyuadvancedclass')-> insert($date);
        }
        if($state)
        {
            Db::table('wyuadvancedclass')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>