<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MCountryencscholarship extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $countryencscholarship = Db::name('countryencscholarship') -> where('stuid','=',$stuid)-> find();
        return $countryencscholarship;
     }

     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('countryencscholarship') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('countryencscholarship')-> insert($date);
        }
        if($state)
        {
            Db::table('countryencscholarship')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>