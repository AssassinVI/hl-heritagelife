<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style>
  .year,.month{    padding: 5px;  font-size: 15px;}
  .dis_total h3{ border-bottom: 1px dashed;  padding-bottom: 10px;  line-height: 1.3;}
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {

	if (empty($_POST['Tb_index'])) {//新增
		$Tb_index='di'.date('YmdHis').rand(0,99);
     
	$StartDate=empty($_POST['StartDate']) ? date('Y-m-d'): $_POST['StartDate'];
	$OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
	$param=  ['Tb_index'=>$Tb_index,
			     'mt_id'=>$_POST['mt_id'],
			'di_name'=>$_POST['di_name'],
			'di_num'=>$_POST['di_num'],
			'di_code'=>$_POST['di_code'],
			'StartDate'=>$StartDate,
		   'OnLineOrNot'=>$OnLineOrNot
		  ];
	pdo_insert('appDiscount', $param);
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }
   else{  //修改

   	$Tb_index =$_POST['Tb_index'];
    
    $param=[  
		      'di_name'=>$_POST['di_name'],
			'di_num'=>$_POST['di_num'],
			'di_code'=>$_POST['di_code']
		   ];
    $where= ['Tb_index'=>$Tb_index] ;
	pdo_update('appDiscount', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}
if ($_GET) {
 	$where=['Tb_index'=>$_GET['Tb_index']];
 	$row=pdo_select('SELECT * FROM appDiscount WHERE Tb_index=:Tb_index', $where);
}
?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
                <div class="col-lg-12">
                  <select class="year">
                   <?php
                     $now_year=date('Y');
                     for ($i=0; $i <10 ; $i++) { 
                        $op_date=(int)$now_year-$i;
                        echo '<option value="'.$op_date.'">'.$op_date.'年度</option>';
                     }
                   ?>
                  </select>
                  <select class="month">
                   <?php
                     $now_month=date('m');
                     for ($i=1; $i <=12 ; $i++) { 
                        
                        $x=$i<10 ? '0'.$i:$i;

                        if($now_month==$i){
                          echo '<option selected value="'.$x.'">'.$i.'月份</option>';
                        }
                        else{
                          echo '<option value="'.$x.'">'.$i.'月份</option>';
                        }
                        
                     }
                   ?>
                  </select>

                  <button id="sub_btn" class="btn btn-success">查詢</button>
                </div>
		
	            <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 class="month_chart">X月份長條圖</h5>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <div id="stocked"></div>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="col-lg-9">
                  <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 class="month_table">X月份表格</h5>
                        </div>
                        <div class="ibox-content">
                            <table border="1" class="table table-hover dis_sal_tb" style="font-size:15px;">
                                <thead>
                                 <tr>
                                   <th>折扣碼</th>

                                  <?php
                                  $row_dis=$pdo_new->select("SELECT di.Tb_index, di.di_name 
                                                             FROM appSalesman as sl
                                                             INNER JOIN appSal_dis as sl_ds ON sl_ds.slm_id=sl.slm_id
                                                             INNER JOIN appDiscount as di ON di.Tb_index=sl_ds.dis_id
                                                             WHERE sl.Tb_index=:Tb_index", ['Tb_index'=>$_GET['Tb_index']]);

                                  $dis_td='';
                                  foreach ($row_dis as $dis) {
                                    $dis_td.='<td class="'.$dis['Tb_index'].'"></td>';
                                    echo '<th id="'.$dis['Tb_index'].'">'.$dis['di_name'].'</th>';
                                  }
                                 ?>

                                 </tr>
                                </thead>
                                <tbody>
                                   
                                   <?php
                                    for ($i=1; $i <=31 ; $i++) { 
                                      echo '<tr>
                                             <th>'.$i.'日</th>';
                                       
                                        echo $dis_td;
                                        
                                      echo '</tr>';
                                    }
                                   ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                  <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 class="month_total">X月份總額</h5>
                        </div>
                        <div class="ibox-content">
                          <div class="dis_total">
                           
                          </div>
                        </div>
                  </div>
                </div>

	</div>
</div><!-- /#page-content -->

<?php  include("../../core/page/footer01.php");//載入頁面footer02.php?>
<script type="text/javascript">
	$(document).ready(function() {

   var month_chart= c3.generate({
                bindto: '#stocked',
                data:{
                    x:'x',
                    columns: [
                        ['x', '02-01', '02-02', '02-03', '02-04', '02-05',],
                        ['data1', 30,200,100,400,150,250],
                        ['data2', 50,20,10,40,15,25]
                    ],
                    colors:{
                        data1: '#1ab394',
                        data2: '#BABABA'
                    },
                    type: 'bar',
                    labels: true,
                    groups: [
                        ['data1', 'data2']
                    ]
                },
                axis:{
                         x:{
                           type:'category'
                         }
                      }
            });




        sal_one_month(month_chart);

        $('#sub_btn').click(function (e) { 

            sal_one_month(month_chart);
        });

      });


function sal_one_month(chart) {
            var Tb_index=location.search.split('=');
                Tb_index=Tb_index[2];
            
            $('.dis_sal_tb tbody tr td').html('');
            $('.month_chart').html($('.month').val()+'月份長條圖');
            $('.month_table').html($('.month').val()+'月份表格');
            $('.month_total').html($('.month').val()+'月份總額');

            $.ajax({
                type: "POST",
                url: "manager_ajax.php",
                data: {
                   type:'sal_one_month',
                   Tb_index:Tb_index,
                   year: $('.year').val(),
                   month: $('.month').val()
                },
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    //-- 表格 --
                    $.each(data, function (indexInArray, valueOfElement) { 
                      var StartDate=this['StartDate'].split(' ');
                          StartDate=StartDate[0].split('-');
                      var day=StartDate[2];
                      $('.dis_sal_tb tbody tr:nth-child('+day+') .'+this['dis_id']).html('$<span>'+this['total']+'</span>');
                    });

                    //-- 總額 --
                    $('.dis_total').html('');
                    $.each($('.dis_sal_tb thead tr th'), function (index, valueOfElement) { 
                       if(index!=0){
                          var dis_total=0;
                          $.each($('.dis_sal_tb tbody tr .'+$(this).attr('id')), function (indexInArray, valueOfElement) { 
                             var dis_money=$(this).find('span').length==0 ? 0:parseInt($(this).find('span').html());
                             dis_total+=dis_money;
                             //console.log(parseInt($(this).find('span').html()));
                          });

                          $('.dis_total').append('<h3>'+$(this).html()+' - 總額：$'+dis_total+'</h3>');
                       }
                    });
                    
                    //-- 長條圖 --
                    var ch_x=['x'];
                    for (let i = 1; i <= 31; i++) {
                      ch_x.push($('.month').val()+'-'+i);
                    }
                    

                    chart.unload();
                    setTimeout(() => {
                      chart.load({
                        columns : columns_arr
		                 });
                    }, 500);

                }
            });
}
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>

