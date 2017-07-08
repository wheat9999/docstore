<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script
    src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js">

</script>

<script>

$(document).ready(function()
    {
        $("#save_id").click(function(){


            var text="";
            var index = 0;
            $("input[name=ids]").each(function() {
                if ($(this).attr("checked")) {
                    if(index == 0)
                    {
                        text += $(this).val();
                    }
                    else {
                        text += "," + $(this).val();
                    }

                    index ++;
                }
            });
            

            $.ajax({
                type:'Get',
                url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/changePublicProp',
                data:{type_id:<?php echo $type_id ?>, proids:text},
                dataType:"json",
                cache : false,
                success:function(msg){
                    window.location.reload();

                }
            });

        });

    });


</script>

<h3>你可以把公共属性加入本文档类型</h3>
<br/><br/>
<table border="1">
    <tr>
        <th>选中</th>
        <th>公共属性</th>
    </tr>

    <?php foreach ($data as $prop) {
        ;
        ?>
        <tr>

            <td>
               <input id="prop_id" name="ids" type="checkbox" <?php if(in_array($prop["id"], $selectIds)) { ?>checked <?php } ?> value="<?php echo $prop["id"]?>"/>
            </td>

            <td>
                <?php echo $prop["name"]?>
            </td>


        </tr>
    <?php }?>
</table>

<br/>
<input id="save_id" type="button" value="保存"/>
