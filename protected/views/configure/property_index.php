<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>
$(document).ready(function()
		{

	$("#menulist").hide();
	$("#pro_type_0").click(function(){
		
		 
		 $("#menulist").hide();

	});
	$("#pro_type_1").click(function(){
				
			 
			 $("#menulist").show();

		});

	$("#pro_type_1").click(function(){
		
		 
		 $("#menulist").show();

	});

	$("#pro_add").click(function(){

		var name = $("#pro_name").val();

//		var checked = $('.mytype:checked ').val();
//
//
//
//		var selectDocType=$("#select_id").find("option:selected").val();
//
//		if(checked == 0)
//		{
//            selectDocType = 0;
//		}



		$.ajax({
			type:'Get',
			url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/proAdd',
			data:{pro_name:name, pro_type:0,type_id:0},
			dataType:"json",
			cache : false,
			success:function(msg){
				window.location.reload();

			}
		});

	});
});

function delProp(proId)
{

	$.ajax({
		type:'Get',
		url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/delPro',
		data:{proId:proId},
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
		<th>操作</th>
	</tr>
	<?php foreach ($data as $docProp) {
		;
		?>
		<tr>

			<td>
				<a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/fieldIndex/proId/<?php echo $docProp["id"]?>">
				<?php echo $docProp["name"]?>
				</a>
			</td>


			<td>
				<a href="javascript:delProp(<?php echo $docProp["id"]?>)" class="btn">
					删除
				</a>
			</td>
		</tr>
	<?php }?>
</table>

<br/>

<h3>您可以添加公共属性，方便重复使用</h3>

<div id="add-type">属性名称: <input type="text" id="pro_name" /> <br />

<!--	是否全局属性: <br />-->
<!-- <input type="radio" id="pro_type_0" class="mytype" name="pro_type" value="0" checked /> 是 <input-->
<!--	type="radio" id="pro_type_1" class="mytype" name="pro_type"  value="1"/>否 <br />-->
<!--<div id="menulist"><select id="select_id">-->
<?php //foreach ($menu as $option) { ?>
<!--	<option value="--><?php //echo $option->id?><!--">--><?php //echo $option->name?><!--</option>-->
<!--	--><?php //}?>
<!---->
<!--</select> <br />-->
</div>

<br/>
<input type="button" id="pro_add" value="添加属性" /></div>
