<?php 
 require '../../core/inc/pdo_fun_calss.php';
 $pdo=NEW PDO_fun;

//-------- 手動搜尋文章 --------
 if (isset($_POST['search_art'])) {
     
    $row=$pdo->select("SELECT Tb_index, aTitle FROM appArticle WHERE Tb_index!=:Tb_index AND aTitle LIKE :aTitle ORDER BY OrderBy DESC, StartDate DESC, Tb_index DESC",['Tb_index'=>$_POST['Tb_index'], 'aTitle'=>'%'.$_POST['search_art'].'%']);
    echo json_encode($row);
 }

 //-------- 推薦文章 --------
 else{

   $row=$pdo->select("SELECT Tb_index, aTitle FROM appArticle WHERE Tb_index!=:Tb_index ORDER BY OrderBy DESC, StartDate DESC, Tb_index DESC",['Tb_index'=>$_POST['Tb_index']]);
   if (count($row)>4) {
      
      $label_query='';
      if (empty($_POST['art_label'])) {
        $label_query=" AND label LIKE '%%' ";
      }
      else{
        $label=explode(',', $_POST['art_label']);
        for ($i=0; $i <count($label) ; $i++) { 
            $label_query.=" AND label LIKE '%".$label[$i]."%' ";
        }
      }
    
    $row=$pdo->select("SELECT Tb_index, aTitle FROM appArticle WHERE Tb_index!=:Tb_index ".$label_query." ORDER BY watch_num DESC, OrderBy DESC, StartDate DESC, Tb_index DESC LIMIT 0,5", ['Tb_index'=>$_POST['Tb_index']]);
   }
   echo json_encode($row);
 }
 
?>