<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MWyucadre extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $wyucadre = Db::name('wyucadre') -> where('stuid','=',$stuid)-> find();
        return $wyucadre;
     }

     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('wyucadre') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('wyucadre')-> insert($date);
        }
        if($state)
        {
            Db::table('wyucadre')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>