<div class="footer">

            <div>
               <strong><?php echo $company['name'] ?> Admin </strong> - Copyright ©<?php echo $company['remark'] ?>
            </div>
        </div>

    </div>
</div>

<!-- Mainly scripts -->
<script src="../../js/jquery-2.1.1.js"></script>
<script
  src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="../../js/inspinia.js"></script>
<script src="../../js/plugins/pace/pace.min.js"></script>

<!-- CKeditor -->
<script src="../../js/plugins/ckeditor/ckeditor.js"></script>
<!-- <script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script> -->

<!-- twzipcode -->
<script src="../../js/plugins/twzipcode/jquery.twzipcode.js"></script>

<!-- AJAX File -->
<script src="../../js/ajaxfileupload.js"></script>

<!-- C3 Chart -->
<script src="../../js/plugins/c3/c3.min.js"></script>
<script src="../../js/plugins/c3/d3.min.js"></script>

<!-- dataTables -->
<script type="text/javascript" charset="utf8" src="../../js/jquery.dataTables.js"></script>

<!-- FancyBox -->
<script type="text/javascript" src="../../js/plugins/fancyBox/jquery.fancybox.js"></script>
<!-- 提示訊息 -->
<script type="text/javascript" src="../../js/plugins/toastr/toastr.min.js"></script>

<!-- 圖片裁切工具 -->
<script type="text/javascript" src="../../js/plugins/cropper/cropper.js"></script>

<!-- 照片訊息 -->
<script type="text/javascript" src="../../js/plugins/exif/exif.js"></script>

<!-- 圖片強功能 -->
<script type="text/javascript" src="../../js/image.js"></script>

</script>

<script type="text/javascript">

if ($('#ckeditor').length>0) {
  	CKEDITOR.replace('ckeditor',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php', height:500});
}
else if($('#ckeditor0').length>0){
    CKEDITOR.replace('ckeditor0',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php', height:500});
    CKEDITOR.replace('ckeditor1',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php', height:200});
    CKEDITOR.replace('ckeditor2',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php', height:200});
    CKEDITOR.replace('ckeditor3',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php', height:200});
    CKEDITOR.replace('ckeditor4',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php', height:200});
}

	/* ==================== 基本AJAX 新增，修改，刪除 ======================= */
	function ajax_in(url, data, alert_txt ,replace) {
		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			success:function () {
        if (alert_txt!='no') { alert(alert_txt); }
				if (replace!='no') { location.replace(replace); }
			}
		});
	}

	/* ===================== AJAX檔案上傳 ======================== */
	function ajax_file(url, file_id, show_id) {

		$.ajaxFileUpload({
              url: url,
              secureuri: false, //是否需要安全協議
              fileElementId: file_id, //上傳input元件ID
              dataType: 'json',
              success: function (data, status) {  //服务器成功响应处理函数

                  alert('檔案儲存');
              }
		});
	}


 /* ========================== 預覽影片方法 ============================= */
 function video_load(controller,html_id) {

            var file=controller.files[0];
             if (file==null) {
                $(html_id).html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function(event){
               // $(html_id).attr('src', this.result);
                $(html_id).html(' <video controls src="'+this.result+'"></video>');
             }
            };
          }


 /* ========================== 預覽圖片方法 ============================= */
 function file_viewer_load_new(controller,html_id) {
            $(html_id).html('');
            var file=controller.files;

            for (var i = 0; i < file.length; i++) {

             if (file[i]==null) {

                 $(html_id).html('');
             }
             else{
                
                var file_name=controller.value.split('\\');
                var type=file_name[2].split('.');
                var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
                
                if (re.exec(file_name[2])) {

                     var fileReader= new FileReader();
                     fileReader.readAsDataURL(file[i]);
                     fileReader.onload = function(event){

                      var image = new Image();
                      image.src = event.target.result;
                      image.onload = function (){
                        // 旋转图片
                        var newImage_result = rotateImage(image);

                          var result=newImage_result;

                          EXIF.getData(image, function() {
                              console.log(EXIF.getTag(this, 'Orientation'));
                              var exif_Orientation=EXIF.getTag(this, 'Orientation');

                                 var html_txt='<div id="img_div" >';
                                 html_txt=html_txt+'<img id="one_img" src="'+result+'" alt="請上傳代表圖檔">';
                                 html_txt=html_txt+'</div>';

                              $(html_id).append(html_txt);
                          });

                      }

                  }
                    
                  }else{
                    alert('請上傳圖片檔');
                    controller.value='';
                  }
            }
          }
}

/**
 * 旋转图片
 * @param image         HTMLImageElement
 * @returns newImage    HTMLImageElement
 */
function rotateImage(image) {
    console.log('rotateImage');

    var width = image.width;
    var height = image.height;

    var canvas = document.createElement("canvas")
    var ctx = canvas.getContext('2d');

    var newImage = new Image();

    //旋转图片操作
    EXIF.getData(image,function () {
            var orientation = EXIF.getTag(this,'Orientation');
            // orientation = 6;//测试数据
            console.log('orientation:'+orientation);
            switch (orientation){
                //正常状态
                case 1:
                    console.log('旋转0°');
                    canvas.height = height;
                    canvas.width = width;
                    ctx.drawImage(image,0,0);
                    imageDate = canvas.toDataURL('Image/jpeg',1);
                    newImage = image;
                    break;
                //旋转90度
                case 6:
                    console.log('旋转90°');
                    canvas.height = width;
                    canvas.width = height;
                    ctx.rotate(Math.PI/2);
                    ctx.translate(0,-height);

                    ctx.drawImage(image,0,0);
                    imageDate = canvas.toDataURL('Image/jpeg',1);
                    newImage.src = imageDate;
                    break;
                //旋转180°
                case 3:
                    console.log('旋转180°');
                    canvas.height = height;
                    canvas.width = width;
                    ctx.rotate(Math.PI);
                    ctx.translate(-width,-height);

                    ctx.drawImage(image,0,0)
                    imageDate = canvas.toDataURL('Image/jpeg',1)
                    newImage.src = imageDate;
                    break;
                //旋转270°
                case 8:
                    console.log('旋转270°');
                    canvas.height = width;
                    canvas.width = height;
                    
                    ctx.rotate(Math.PI/2);
                    ctx.translate(0,-height);
                    ctx.rotate(Math.PI);
                    ctx.translate(-width,-height);

                    ctx.drawImage(image,0,0)
                    imageDate = canvas.toDataURL('Image/jpeg',1)
                    newImage.src = imageDate;
                    break;
                //undefined时不旋转
                case undefined:
                    console.log('undefined  不旋转');
                    canvas.height = height;
                    canvas.width = width;
                    ctx.drawImage(image,0,0);
                    imageDate = canvas.toDataURL();
                    newImage = image;
                    break;
            }
        }
    );
    return imageDate;
}

 /* ========================== 預覽檔案方法 ============================= */
 function file_load_new(controller,html_id) {
            $(html_id).html('');
            var file=controller.files;
            for (var i = 0; i < file.length; i++) {

             if (file[i]==null) {

                 $(html_id).html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file[i]);
                fileReader.onload = function(event){

                //$(html_id).attr('src', this.result);
                var file_name=controller.value.split('\\');
                var type=file_name[2].split('.');
                var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;

                if (re.exec(file_name[2])) {
                    var result=this.result;
                  }else{
                    var result='../../img/other_file_img/file.svg';
                  }

           var html_txt='<div id="img_div" >';
           html_txt=html_txt+'  <img id="one_img" src="'+result+'" alt="請上傳代表圖檔">';
           html_txt=html_txt+'</div>';

              $(html_id).append(html_txt);
             }
            }
          }
}

/*  */
function save_img_btn(ajax_php, file_id) {
  ajax_file(ajax_php, file_id, '#one_img');
  //$('.img_check').css('display', 'block');
}

/* ======================== 重設表單 ========================== */
function clean_all() {
   if (confirm("是否要重設表單??")) {
      window.location.reload();
   }
}

/* ===================== 燈箱 =================== */
$(".fancybox").fancybox();


    // =============================== 檢查input ====================================
function check_input(id,txt) {

          if ($(id).attr('type')=='radio' || $(id).attr('type')=='checkbox') {
            
            if($(id+':checked').val()==undefined){
             $(id).css('borderColor', 'red');
              return txt;
           }else{
              $(id).css('borderColor', 'rgba(0,0,0,0.1)');
              return "";
           }
          }else{
            if ($(id).val()=='') {
              $(id).css('borderColor', 'red');
              return txt;
           }else{
              $(id).css('borderColor', 'rgba(0,0,0,0.1)');
              return "";
           }
          }
  }
  
  //-- 判斷特殊符號 --
  function check_word(id) {
     if($(id).val().search(/^(?:[^\~|\!|\#|\$|\%|\^|\&|\*|\(|\)|\=|\+|\{|\}|\[|\]|\"|\'|\<|\>]+)$/)==-1){
        $(id).css('borderColor', 'red');
        return true;
     }
     else{
        $(id).css('borderColor', 'rgba(0,0,0,0.1)');
       return false;
     }
  }
  
  //-- 判斷Email --
  function check_email(id) {
    if($(id).val().search(/^\w+(?:(?:-\w+)|(?:\.\w+))*\@\w+(?:(?:\.|-)\w+)*\.[A-Za-z]+$/)>-1){
        $(id).css('borderColor', 'red');
        return true;
     }
     else{
        return false;
     }
  }

</script>