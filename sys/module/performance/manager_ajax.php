<?php
  include "../../core/inc/config.php"; //載入基本設定
  include "../../core/inc/function.php"; //載入基本function
  include "../../core/inc/pdo_fun_calss.php";
  include "../../core/inc/security.php"; //載入安全設定

  if($_POST){
    $pdo=new PDO_fun;
    if($_POST['type']=='sal_one_month'){
       
        $row_sal=$pdo->select("SELECT sl.total, sl_ds.dis_id, sl.StartDate
                               FROM shop_List as sl
                               INNER JOIN appSal_dis as sl_ds ON sl_ds.dis_id=sl.dis_id
                               INNER JOIN appSalesman as slm ON slm.slm_id=sl_ds.slm_id
                               WHERE slm.Tb_index=:Tb_index AND sl.StartDate LIKE :StartDate", ['Tb_index'=>$_POST['Tb_index'], 'StartDate'=>$_POST['year'].'-'.$_POST['month'].'%']);

      echo json_encode($row_sal);
        
       // $row_sal_dis=$pdo->select("SELECT dis_id FROM appSal_dis WHERE slm_id=:slm_id", ['slm_id'=>$row_sal['slm_id']]);
    }
  }
?>