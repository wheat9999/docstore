<?php @header('Content-type: text/html;charset=UTF-8'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>

    $(document).ready(function()
    {

        $("#ck_type").click(function()
        {

            if ($(this).attr("checked"))
            {

                var rule = $("#rule").val();

                $("#rule").val(rule+"{T}");

            }




        });

        $("#ck_seri").click(function()
        {

            if ($(this).attr("checked"))
            {



                var rule = $("#rule").val();

                $("#rule").val(rule+"{S01}");

            }




        });

        $("input[id*='ck_pro']").click(function()
        {


            if ($(this).attr("checked"))
            {



                var rule = $("#rule").val();
                var proId = $(this).val();

                $("#rule").val(rule+"{P"+proId+"}");

            }




        });


        $("#save_id").click(function(){


            var text= $("#rule").val();



            $.ajax({
                type:'Get',
                url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/updateRule',
                data:{typeId:<?php echo $typeId ?>, rule:text},
                dataType:"json",
                cache : false,
                success:function(msg){

                    window.location.reload();

                }
            });

        });
    });

</script>

<table border="1">
    <tr>
        <th>选择</th>
        <th>属性名称</th>
        <th>属性代号</th>
        <th>属性范围</th>

    </tr>
    <?php foreach ($data as $docProp) {
        ;
        ?>
        <tr>

            <td><input type="checkbox" value="<?php echo $docProp["id"]?>" id="ck_pro<?php echo $docProp["id"]?>"> </td>

            <td>
                <a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/fieldIndex/proId/<?php echo $docProp["id"]?>">
                    <?php echo $docProp["name"]?>
                </a>
            </td>

            <td> <?php echo $docProp["id"]?></td>

            <td>
                <?php if($docProp["property_type"] == 0)
                     echo '全局属性';
                else
                    echo '文档属性';

        ?>
            </td>

        </tr>
    <?php }?>

</table>

<br/>

<input type="checkbox" value="" id="ck_type"> 文档编号:

<br/>
<input type="checkbox" value="" id="ck_seri"> 版本号

<br/>
<br/>

<h3>你可以编辑编号规则</h3>
<input type="text" value="<?php echo $rule; ?>" id="rule" size="60"/>

<br/>
<br/>
<input type="button" value="保存" id="save_id"/>