<?php @header('Content-type: text/html;charset=UTF-8'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>
	$(document).ready(function() {

		$("#menulist").hide();
		$("#auto_field").hide();

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

		$("#option_add").click(function(){

			var value = $("#option_value").val();

			var key = $("#option_key").val();

			var selectObj=document.getElementById("select_id");

			selectObj.options[selectObj.length] = new Option(value, key);

			$("#option_value").val("");
			$("#option_key").val("");
			$("#option_0").attr("checked","checked");


		});

		$("#field_add").click(function(){


			var name = $("#field_name").val();


			var type = $('.mytype:checked ').val();


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
				url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/quickAdd',
				data:{typeId:<?php echo $typeId ?>,type:type,name:name,value:value,menulist:fieldMenus},
				dataType:"json",
				cache : false,
				success:function(msg){
					window.location.reload();

				}
			});

		});
	});

	function delField(fieldId)
	{

		$.ajax({
			type:'Get',
			url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/quickDel',
			data:{fieldId:fieldId},
			dataType:"json",
			cache : false,
			success:function(msg){

				window.location.reload();

			}
		});

	}
</script>



<table border="1">
	<tr>
		<th>属性名称</th>

		<th>输入类型</th>

		<th>操作</th>


	</tr>
	<?php foreach ($data as $field) {
		;
		?>
		<tr>

			<td>
				<?php echo $field["name"]?>
			</td>

			<td>
				<?php  if ($field["type"] == 0)
				echo "自由输入";
				else if($field["type"] == 1)
				echo "菜单选择";
				else
				echo "自动增长";


				?>
			</td>

			<td>
				<a href="javascript:delField(<?php echo $field["id"]?>)" class="btn">
					删除
				</a>
			</td>


		</tr>
	<?php }?>
</table>

<br/>
<br/>

<h3>新增属性</h3>
<br/>

<div id="add-type">属性名称: <input type="text" id="field_name" />
	<br />
	<br/>

	输入类型: <br />
	<input type="radio" id="pro_type_0" class="mytype" name="pro_type" value="0" checked /> 自由输入 <input
		type="radio" id="pro_type_1" class="mytype" name="pro_type"  value="1"/>菜单选择
	<input
		type="radio" id="pro_type_2" class="mytype" name="pro_type"  value="2"/> 自增长<br />

	<div id="menulist">
		<br/>
		<select id="select_id">
		</select>
		选项:<input type="text" id="option_value" /> 值:<input type="text" id="option_key" />
		<input type="button" id="option_add" value="新增选项" />

		<br />
	</div>

	<div id="auto_field">

		<br/>
		初始值:<input type="text" id = "auto_value" value="001"/>

	</div>

	<br/>
	<input type="button" id="field_add" value="新增属性" /></div>

