<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MPovertysl extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $povertysl = Db::name('povertysl') -> where('stuid','=',$stuid)-> find();
        return $povertysl;
     }

     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('povertysl') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('povertysl')-> insert($date);
        }
        if($state)
        {
            Db::table('povertysl')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>