<?php
require '../../core/inc/pdo_fun_calss.php';
if ($_POST) {

  $pdo=new PDO_fun;
  
  //=====================================--- 流水號 ----=======================================

	if ($_POST['type']=='serial_num') {
    //-- 品牌類型+品牌編碼 --
      $row_brand=$pdo->select("SELECT serial_type,serial_brand FROM appBrand WHERE Tb_index=:Tb_index", ['Tb_index'=>$_POST['Tb_index']]);
      //-- 最新產品流水號 --
        $row_pro=$pdo->select("SELECT serial_num FROM appProduct WHERE aBrand=:aBrand ORDER BY serial_num DESC LIMIT 0,1", ['aBrand'=>$_POST['Tb_index']]);

        if (empty($row_pro[0]['serial_num'])) {

          $serial_num=$row_brand[0]['serial_type'].$row_brand[0]['serial_brand'].date('Y').'001';
        }
        else{

           $num=substr($row_pro[0]['serial_num'], -3);
           $num=(int)$num+1;

           if ($num>=100) {
            $num=(string)$num;
           }
           elseif($num>=10){
            $num='0'.(string)$num;
           }
           else{
            $num='00'.(string)$num;
           }

           $serial_num=$row_brand[0]['serial_type'].$row_brand[0]['serial_brand'].date('Y').$num;
        }

        echo  $serial_num;
  }

	//=======================================--- 推薦文章 ----===============================================

	elseif($_POST['type']=='recommend_art'){

    //-------- 手動搜尋文章 --------
     if (isset($_POST['search_art'])) {
         
        $row=$pdo->select("SELECT Tb_index, aTitle FROM appArticle WHERE Tb_index!=:Tb_index AND OnLineOrNot='1' AND aTitle LIKE :aTitle ORDER BY OrderBy DESC, StartDate DESC, Tb_index DESC",['Tb_index'=>$_POST['Tb_index'], 'aTitle'=>'%'.$_POST['search_art'].'%']);
        echo json_encode($row);
     }

     //-------- 推薦文章 --------
     else{

       $row=$pdo->select("SELECT Tb_index, aTitle FROM appArticle WHERE Tb_index!=:Tb_index AND OnLineOrNot='1'",['Tb_index'=>$_POST['Tb_index']]);
       if (count($row)>5) {
          
          $label_query='';
          if (empty($_POST['art_label'])) {
            $label_query=" AND label LIKE '%%' ";
          }
          else{
            $label_query_one='';

            $label=explode(',', $_POST['art_label']);
            for ($i=0; $i <count($label) ; $i++) { 
                $label_query_one.="OR label LIKE '%".$label[$i]."%' ";
            }

            $label_query.=" AND (".substr($label_query_one, 2) .") ";
          }
        
        $row=$pdo->select("SELECT Tb_index, aTitle FROM appArticle WHERE Tb_index!=:Tb_index AND OnLineOrNot='1' ".$label_query." ORDER BY watch_num DESC, OrderBy DESC, StartDate DESC, Tb_index DESC LIMIT 0,5", ['Tb_index'=>$_POST['Tb_index']]);
       }
       echo json_encode($row);
     }
  }
  

  //===================================================--- 推薦產品 ----=======================================================

  elseif($_POST['type']=='recommend_pro'){

    //-------- 手動搜尋產品 --------
     if (isset($_POST['search_pro'])) {
         
        $row=$pdo->select("SELECT Tb_index, aTitle FROM appProduct WHERE Tb_index!=:Tb_index AND OnLineOrNot='1' AND aTitle LIKE :aTitle ORDER BY OrderBy DESC, StartDate DESC, Tb_index DESC",['Tb_index'=>$_POST['Tb_index'], 'aTitle'=>'%'.$_POST['search_pro'].'%']);
        echo json_encode($row);
     }

     //-------- 推薦產品 --------
     else{

       $row=$pdo->select("SELECT Tb_index, aTitle FROM appProduct WHERE Tb_index!=:Tb_index AND OnLineOrNot='1'",['Tb_index'=>$_POST['Tb_index']]);
       if (count($row)>5) {
          
          $label_query='';
          if (empty($_POST['label_pro'])) {
            $label_query=" AND label_pro LIKE '%%' ";
          }
          else{
            $label_query_one='';

            $label=explode(',', $_POST['label_pro']);
            for ($i=0; $i <count($label) ; $i++) { 
                $label_query_one.="OR label_pro LIKE '%".$label[$i]."%' ";
            }

            $label_query.=" AND (".substr($label_query_one, 2) .") ";
          }
        
        $row=$pdo->select("SELECT Tb_index, aTitle FROM appProduct WHERE Tb_index!=:Tb_index AND OnLineOrNot='1' ".$label_query." ORDER BY watch_num DESC, OrderBy DESC, StartDate DESC, Tb_index DESC LIMIT 0,5", ['Tb_index'=>$_POST['Tb_index']]);
       }
       echo json_encode($row);
     }

  }


   //===================================================--- 是否為推薦產品 ----=======================================================
   if ($_POST['type']=='is_HotPro') {
     
     $pdo->update('appProduct', ['HotPro'=>$_POST['HotPro']], ['Tb_index'=>$_POST['Tb_index']]);
   }


}
?>