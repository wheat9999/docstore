<?php @header('Content-type: text/html;charset=UTF-8'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>
$(document).ready(function()
		{

	$("#menulist").hide();
	$("#auto_field").hide();

	<?php if(count($data)<2){ ?>

		$("#input_select").hide();
    <?php }?>


	$("#pro_type_0").click(function(){
		
		 
		 $("#menulist").hide();
		$("#auto_field").hide();

	});
	$("#pro_type_1").click(function(){
				
			 
			 $("#menulist").show();
		     $("#auto_field").hide();

		});

	$("#pro_type_2").click(function(){
		
		 
		 $("#menulist").hide();
		$("#auto_field").show();

	});

	$("#field_add").click(function(){


		var name = $("#field_name").val();

		var code = '**';

		var type = $('.mytype:checked ').val();

		var proId = <?php echo $pro->id ?>

		var value = $("#auto_value").val();

		var obj = document.getElementById('select_id');
		var options = obj.options;
		var fieldMenus = "";

		for(var i=0;i<options.length;i++)
		{
			var opt = options[i];

			fieldMenus += opt.value+","+opt.text;

			if(i!= options.length-1)
			{
				fieldMenus += "$";
			}
	    }

		$.ajax({
			type:'Get',
			url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/fieldAdd',
			data:{proId:proId, type:type,name:name,code:code,value:value,menulist:fieldMenus},
			dataType:"json",
			cache : false,
			success:function(msg){


				window.location.reload();

			}
		});

	});

			$("#option_add").click(function(){

				var value = $("#option_value").val();

				var key = $("#option_key").val();

				var selectObj=document.getElementById("select_id");

				selectObj.options[selectObj.length] = new Option(value, key);

				$("#option_value").val("");
				$("#option_key").val("");
				$("#option_0").attr("checked","checked");


			});
});

	function onMySelect(obj)
	{
		var proId = <?php echo $pro->id ?>

		$.ajax({
			type:'Get',
			url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/changeSource',
			data:{proId:proId, fieldId:obj.value},
			dataType:"json",
			cache : false,
			success:function(msg){


				window.location.reload();

			}
		});


	}

</script>
<h3>
公共属性:<?php echo $pro->name ?>
</h3>

<table border="1">
	<tr>
		<th>字段名称</th>

		<th>输入方式</th>


	</tr>
	<?php foreach ($data as $docF) {
		;
		?>
		<tr>

			<td>
				<?php echo $docF["name"]?>
			</td>


			<td>
				<?php if($docF["type"] == 0)
					echo "自由输入";
				elseif($docF["type"] ==1)
					echo "菜单选择";
				else
					echo "自增长";

				?>
			</td>

		</tr>
	<?php }?>
</table>

<br/>
<h3>
	添加字段到属性中
</h3>
<div id="add-type">字段名称: <input type="text" id="field_name" /> <br /><br />

<!--	栏目编码: <input type="text" id="field_code" /> <br />-->
输入方式: <br />
 <input type="radio" id="pro_type_0" class="mytype" name="pro_type" value="0" checked /> 自由输入 <input
	type="radio" id="pro_type_1" class="mytype" name="pro_type"  value="1"/>菜单选择
	 <input
		type="radio" id="pro_type_2" class="mytype" name="pro_type"  value="2"/> 自增长<br />
<div id="menulist">
	<br/>
	<select id="select_id">

</select>
	选项:<input type="text" id="option_value" /> 值:<input type="text" id="option_key" />
	<input type="button" id="option_add" value="确定" />

	<br />
</div>

	<div id="auto_field">
<br/>
     初始值:<input type="text" id = "auto_value" value="001"/>

	</div>

	<br/>
</div>


<div id="input_select">
 选择用户的输入源:	<select id="source_select" onchange="onMySelect(this)">
      <?php foreach ($data as $docF) { ?>
      <option value="<?php echo $docF["id"] ?>"  <?php if($docF["is_select"] ==1 ) echo "selected" ?>><?php echo $docF["name"]?></option>
	  <?php } ?>

	</select>
	<br/>
</div>

<input type="button" id="field_add" value="添加字段" />