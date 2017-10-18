<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MWyumeritstudent extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $wyumeritstudent = Db::name('wyumeritstudent') -> where('stuid','=',$stuid)-> find();
        return $wyumeritstudent;
     }

     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('wyumeritstudent') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('wyumeritstudent')-> insert($date);
        }
        if($state)
        {
            Db::table('wyumeritstudent')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>