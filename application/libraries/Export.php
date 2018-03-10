<?php
/**
 * 导出类
 *
 * createtable      ---  导出excel表格格式
 * excelToArray     ---  读取excel文件转成php数组
 * excelToArray2    ---  读取excel文件转成php数组
 * exportExcel      ---  通过PHPExcel导出excel
 * exportExcel2     ---  使用excel模板导出
 */

class Export
{
	public function __construct()
    {
		$this->ci = & get_instance ();
		//$this->base_url = $this->ci->config->base_url();

		//FCPATH;  物理路径
	}

    /**
     * 读取excel转成php数组
     *
     * @parames     string  $filename  excel文件的完整路径
     * @return      array   php数组
     */
    public function excelToArray($filename = '')
    {
        require_once FCPATH . 'application/libraries/excel/PHPExcel/IOFactory.php';

        $objPHPExcelReader = PHPExcel_IOFactory::load($filename);

        $sheet = $objPHPExcelReader->getSheet(0);        // 读取第一个工作表(编号从 0 开始)
        $highestRow = $sheet->getHighestRow();           // 取得总行数
        $highestColumn = $sheet->getHighestColumn();     // 取得总列数

        $arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        // 一次读取一列
        $res_arr = array();
        for ($row = 2; $row <= $highestRow; $row++) {
            $row_arr = array();
            for ($column = 0; $arr[$column] != 'F'; $column++) {
                $val = $sheet->getCellByColumnAndRow($column, $row)->getValue();
                $row_arr[] = $val;
            }

            $res_arr[] = $row_arr;
        }

        return $res_arr;
    }

    /**
     * 读取excel转成php数组
     *
     * @parames     string  $filename  excel文件的完整路径
     * @return      array   php数组
     */
    public function excelToArray2($filename = '')
    {
        require_once FCPATH . 'application/libraries/excel/PHPExcel/IOFactory.php';

        $objPHPExcelReader = PHPExcel_IOFactory::load($filename);

        $reader = $objPHPExcelReader->getWorksheetIterator();
        //循环读取sheet
        foreach($reader as $sheet) {
            //读取表内容
            $content = $sheet->getRowIterator();
            //逐行处理
            $res_arr = array();
            foreach($content as $key => $items) {

                 $rows = $items->getRowIndex();              //行
                 $columns = $items->getCellIterator();       //列
                 $row_arr = array();
                 //确定从哪一行开始读取
                 if($rows < 2){
                     continue;
                 }
                 //逐列读取
                 foreach($columns as $head => $cell) {
                     //获取cell中数据
                     $data = $cell->getValue();
                     $row_arr[] = $data;
                 }
                 $res_arr[] = $row_arr;
            }

        }

        return $res_arr;
    }

    /**
     * 创建(导出)Excel数据表格
     * @param  array   $list        要导出的数组格式的数据
     * @param  string  $filename    导出文件名(无后缀)
     * @param  array   $indexKey    $list数组中与Excel表格表头$header中每个项目对应的字段的名字(key值)
     * @param  array   $startRow    第一条数据在Excel表格中起始行
     * @param  [bool]  $excel2007   是否生成Excel2007(.xlsx)以上兼容的数据表
     * 比如: $indexKey与$list数组对应关系如下:
     *     $indexKey = array('id','username','sex','age');
     *     $list = array(array('id'=>1,'username'=>'YQJ','sex'=>'男','age'=>24));
     */
    public function exportExcel($list,$filename,$indexKey,$startRow=1,$excel2007=false)
    {
        //文件引入
        require_once FCPATH . 'application/libraries/excel/PHPExcel.php';
        require_once FCPATH . 'application/libraries/excel/PHPExcel/Writer/Excel2007.php';

        if(empty($filename)) $filename = time();
        if( !is_array($indexKey)) return false;

        $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        //初始化PHPExcel()
        $objPHPExcel = new PHPExcel();

        //设置保存版本格式
        if($excel2007){
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $filename = $filename.'.xlsx';
        }else{
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $filename = $filename.'.xls';
        }

        //接下来就是写数据到表格里面去
        $objActSheet = $objPHPExcel->getActiveSheet();
        //$startRow = 1;
        foreach ($list as $row) {
            foreach ($indexKey as $key => $value){
                //这里是设置单元格的内容
                $objActSheet->setCellValue($header_arr[$key].$startRow,$row[$value]);
            }
            $startRow++;
        }

        // 下载这个表格，在浏览器输出
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename='.$filename.'');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    /**
     * 使用模板导出excel
     *
     * @parames array   $list       要导出的数组格式的数据
     * @parames string  $filename   要导出的文件名
     * @parames string  $template   excel模板(完整路径)
     * @parames array   $indexKey   $list数组中与Excel表格表头$header中每个项目对应的字段的名字(key值)
     *
     * 比如: $indexKey与$list数组对应关系如下:
     * $indexKey = array('id','username','sex','age');
     * $list = array(array('id'=>1,'username'=>'YQJ','sex'=>'男','age'=>24));
     *
     */
    public function exportExcel2($list,$filename,$template='',$indexKey=array())
    {
        // 导入文件
        require_once FCPATH . 'application/libraries/excel/PHPExcel/IOFactory.php';
        require_once FCPATH . 'application/libraries/excel/PHPExcel.php';
        require_once FCPATH . 'application/libraries/excel/PHPExcel/Writer/Excel2007.php';

        // excel表头序号
        $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        //$header_arr = array('L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH');

        //初始化PHPExcel(),不使用模板
        //$objPHPExcel = new PHPExcel();

        //加载excel文件,设置模板
        $objPHPExcel = PHPExcel_IOFactory::load($template);

        //设置保存版本格式
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

//ob_end_clean();
//ob_start();

        //接下来就是写数据到表格里面去
        $objActSheet = $objPHPExcel->getActiveSheet();

        //$objActSheet->setCellValue('A2',  "活动名称：江南极客");
        //$objActSheet->setCellValue('C2',  "导出时间：".date('Y-m-d H:i:s'));

        // $i是从第几行开始写入数据
        $i = 2;
        foreach ($list as $row) {
            foreach ($indexKey as $key => $value){
                //这里是设置单元格的内容
                $objActSheet->setCellValue($header_arr[$key].$i,$row[$value]);
            }
            $i++;
        }

        // 1.保存至本地Excel表格
        //$objWriter->save($filename);

        // 2.接下来当然是下载这个表格了，在浏览器输出就好了
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$filename);
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    /**
     * 创建(导出)Excel数据表格
     * @param  array   $list 要导出的数组格式的数据
     * @param  string  $filename 导出的Excel表格数据表的文件名
     * @param  array   $header Excel表格的表头
     * @param  array   $index    $list数组中与Excel表格表头
     *
     *      $header中每个项目对应的字段的名字(key值)
     *      比如:
     *      $header = array('编号','姓名','性别','年龄');
     *      $index = array('id','username','sex','age');
     *      $list = array(array('id'=>1,'username'=>'YQJ',
                    'sex'=>'男','age'=>24));
     *
     * @param   string  $ext 导出文件格式  默认 xls
     * @return [array] [数组]
     */

    /* 使用demo:

        $filename = '提现记录'.date('YmdHis');
        $header = array('会员','编号','联系电话','开户名','开户行','申请金额','手续费','实际金额','申请时间');

        $index = array('username','vipnum','mobile','checkname','bank','money','handling_charge','real_money','applytime');

        $this->createtable($cash,$filename,$header,$index);
    */

    public function createtable($list,$filename,$header=array(),$index = array(),$ext="xls")
    {
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=".$filename.".".$ext);
        $teble_header = implode(",",$header);
        $strexport = $teble_header."\r";
        foreach ($list as $row){
            foreach($index as $val){
                $strexport.=$row[$val].",";
            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        echo $strexport;
        exit();
    }

}
?>
