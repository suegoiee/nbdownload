<?php
    function exportCSVAction($request)
    {
        $fileName = $request['title'];  //這裡定義表名。簡單點的就直接  $fileName = time();

        header('Content-Type: application/vnd.ms-excel');   //header設定
        header("Content-Disposition: attachment;filename=".$fileName.".csv");
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output','a');    //開啟php檔案控制代碼，php://output表示直接輸出到PHP快取,a表示將輸出的內容追加到檔案末尾

        $head = array('工號','部門名','崗位名','學員名','報名時間','狀態','課程建議');  //表頭資訊
        foreach($request['head'] as $th){
            array_push($head, iconv("UTF-8","GBK//IGNORE",$th));
        }
        fputcsv($fp,$head);  //fputcsv() 函式將行格式$head化為 CSV 並寫入一個開啟的檔案$fp。 

        if (!empty($request['content'])) {  
            $data = [];  //要匯出的資料的順序與表頭一致；提前將最後的值準備好（比如：時間戳轉為日期等）
            foreach ($request['content'] as $tbodyKey => $tbody) {
                foreach($tbody as $tdkey => $td){  //$item為一維陣列哦
                    $data[$tdkey] = iconv("UTF-8","GBK//IGNORE",$td);  //轉為gbk的時候可能會遇到特殊字元‘-’之類的會報錯，加 ignore表示這個特殊字元直接忽略不做轉換。
                }
                fputcsv($fp,$data);
            }
            exit;  //記得加這個，不然會跳轉到某個頁面。
        }
    }
?>