
<?php @header('Content-type: text/html;charset=UTF-8'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />


<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>
$(document).ready(function()
		{
	$("#doc_add").click(function(){
		
		 $.ajax({
				type:'Get',
				url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/docAdd',
				data:{doc_name:$("#doc_type").val(), doc_code:$("#doc_code").val()},
				dataType:"json",
				cache : false,
				success:function(msg){

				window.location.reload();
					
				}                    
				});
		});

	});

	function delType(typeId)
	{
		$.ajax({
			type:'Get',
			url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/delType',
			data:{typeId:typeId},
			dataType:"json",
			cache : false,
			success:function(msg){

				window.location.reload();

			}
		});

	}
</script>


<table  width="80%">
<tr>
<th>文档类型</th>
<th>文档编码</th>
	<th>操作</th>
</tr>
<?php foreach ($data as $docType) {
	;
?>
<tr>

<td>
	<a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/privateIndex/typeId/<?php echo $docType->id?>">
<?php echo $docType->name?>
	</a>
</td>

<td>
<?php echo $docType->code?>
</td>
	<td>
		<a href="javascript:delType(<?php echo $docType->id?>)" class="btn">
		删除
		</a>
	</td>
</tr>
<?php }?>
</table>

<br/>
<br/>
<h3>新增文档类型</h3>

<br/>
<div id="add-type">
文档类型:
<input type="text"  id="doc_type"/>

文档编码:
<input type="text" id="doc_code"/>

<input type="button" id="doc_add" value="新增"/>

</div>
