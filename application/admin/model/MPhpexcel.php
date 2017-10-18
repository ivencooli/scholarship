<?php
namespace app\admin\model;
use think\Model;
use think\Session;
use think\Db;
use PHPExcel;     
 use PHPExcel_IOFactory;
class MPhpexcel {
 	 var $startrow = 0;

  function __construct($fn) {
	    $this->tpl = PHPExcel_IOFactory::load($fn);
	    $this->target = clone $this->tpl;
  }

  function add_data($ar) {
	    $sheet = $this->tpl->getActiveSheet();
	    $i = 0;
	    $mcol = $sheet->getHighestColumn();
	    foreach($sheet->getRowDimensions() as $y=>$row) {
		      for($x='A'; $x<=$mcol; $x++) {
			        $txt = trim($sheet->getCell($x.$y)->getValue());
			        if($txt && preg_match('/{(.+)}/', $txt, $match)) {
			          	$txt = isset($ar[$match[1]]) ? iconv('utf-8', 'utf-8', $ar[$match[1]]) : '';
			        }
			        $h = $y + $this->startrow;
			        $this->target->getActiveSheet()->getCell("$x$h")->setValue($txt);
			        $this->target->getActiveSheet()->duplicateStyle($sheet->getStyle("$x$y"), "$x$h");
		      }
	    }
	    foreach($sheet->getMergeCells() as $merge) {
		      $merge = @preg_replace('/\d+/e',"$0+$this->startrow", $merge);
		      $this->target->getActiveSheet()->mergeCells($merge);
	    }
  }

  function output($fn) {
	    $t = PHPExcel_IOFactory::createWriter($this->target, 'Excel5');
	    header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件  
                  header('Content-Disposition: attachment;filename="'.$fn.'"');//告诉浏览器将输出文件的名称(文件下载)  
                  header('Cache-Control: max-age=0');//禁止缓存  
                  $t->save("php://output");  
    }

}


?>