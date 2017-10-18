<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;

class MCountryscholarship extends Model
{   
    //查询数据
    public function search($stuid)
    {
        $countryscholarship = Db::name('countryscholarship') -> where('stuid','=',$stuid)-> find();
        return $countryscholarship;
     }

     //储存数据
     public function savedate($date,$stuid)
     {
        $state = Db::table('countryscholarship') -> where('stuid','=',$stuid)-> find();
        if(!$state)
        {
            $date['stuid'] = $stuid;
            Db::table('countryscholarship')-> insert($date);
        }
        if($state)
        {
            Db::table('countryscholarship')->where('stuid', Session('stuid'))->update($date);
        }
     }

 }
 ?>