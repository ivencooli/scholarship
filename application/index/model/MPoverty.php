<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MPoverty extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $poverty = Db::name('poverty') -> where('stuid','=',$stuid)-> find();
        return $poverty;
     }

     public function searchstuuser($stuid)
     {
        $inf = Db::name('studentuser') -> where('stuid','=',$stuid)-> find();
        return $inf;
     }
     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('poverty') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('poverty')-> insert($date);
        }
        if($state)
        {
            Db::table('poverty')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>