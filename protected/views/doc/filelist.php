<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script
    src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>

<script>


  function del(resourceId)
  {

      $.ajax({
          type:'Get',
          url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/delResource',
          data:{resourceId:resourceId},
          dataType:"json",
          cache : false,
          success:function(msg){

              alert("add succ");
              window.location.reload();

          }

      });
  }

</script>

<h3>上传文件</h3>


<table border="1">
    <tr>
        <th>文档名称</th>
        <th>上传时间</th>
        <th>操作人</th>
        <th>操作</th>
    </tr>
    <?php foreach ($resourcelist as $resource) {
        ;
        ?>
        <tr>

            <td>

                <?php if(Yii::app()->user->getRole()!= 2) {?>
                <a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/files/<?php echo $resource["path"] ?>">
                    <?php echo $resource["name"]?>
                </a>
                <?php } else echo $resource["name"]; ?>
            </td>

            <td>

                    <?php echo $resource["create_time"] ?>

            </td>
            <td>

                <?php echo $userlist[$resource["user_id"]] ?>
            </td>
            <td>
               <?php if(Yii::app()->user->getRole()!= 2) {?>
                <input type="button" value="删除" onclick="del(<?php echo $resource["id"] ?>)"/>
                <?php } ?>

            </td>
        </tr>
    <?php }?>
</table>

<?php if(Yii::app()->user->getRole()!= 2) {?>
<form action="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/uploadFile" method="post" enctype="multipart/form-data" >

<input type="file" name="file"/>
<input type="hidden" name="revision" value="<?php echo $revisonId ?>"/>
    <input type="submit" value="上传"/>
</form>

<?php } ?>
