<!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>

    <script>

    // =============================== 檢查input ====================================
    function check_input(id,txt) {
		if($(id).length>0){
			//-- 核取方塊、選取方塊 --
			if ($(id).attr('type')=='radio' || $(id).attr('type')=='checkbox') {
				if($(id+':checked').val()==undefined){
					$(id).css('borderColor', 'red');
					return txt;
				}else{
					$(id).css('borderColor', 'rgba(0,0,0,0.1)');
					return "";
				}
			}else{
				if ($(id).val()=='' || $(id).val().search(/^(?:[^\~|\!|\#|\$|\%|\^|\&|\*|\(|\)|\=|\+|\{|\}|\[|\]|\"|\'|\<|\>]+)$/)==-1) {
					$(id).css('borderColor', 'red');
					return txt;
				}else{
					$(id).css('borderColor', 'rgba(0,0,0,0.1)');
					return "";
				}
			}
		}else{
			return txt;
		}
	}
    </script>

    <?php 
      $pdo=NULL;
    ?>