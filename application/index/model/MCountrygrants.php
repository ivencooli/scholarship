<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MCountrygrants extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $countrygrants = Db::name('countrygrants') -> where('stuid','=',$stuid)-> find();
        return $countrygrants;
     }

     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('countrygrants') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('countrygrants')-> insert($date);
        }
        if($state)
        {
            Db::table('countrygrants')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>