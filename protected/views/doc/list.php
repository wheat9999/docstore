<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script
    src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>
//    $(document).ready(function() {
//
//
//        $("#add").click(function(){
//
//            var name = $("#pro_name").val();
//
//            var checked = $('.mytype:checked ').val();
//
//
//
//            var selectDocType=$("#select_id").find("option:selected").val();
//            var href = "<?php //echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>///doc/add/typeId/"+selectDocType;
//
//
//            window.location= href;
//
//        });
//
//        });

    function updateRevison(typeId,recordId)
    {



        $.ajax({
            type:'Get',
            url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/update',
            data:{typeId:typeId, recordId:recordId},
            dataType:"json",
            cache : false,
            success:function(msg){


                window.location.reload();

            }

        });
    }
    function delRevison(revisionId,recordId)
    {




        $.ajax({
            type:'Get',
            url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/del',
            data:{revisionId:revisionId,recordId:recordId},
            dataType:"json",
            cache : false,
            success:function(msg){


                window.location.reload();

            }

        });
    }

    function addDoc()
    {
        var name = $("#pro_name").val();

        var checked = $('.mytype:checked ').val();



        var selectDocType=$("#select_id").find("option:selected").val();
        var href = "<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/add/typeId/"+selectDocType;


        window.location= href;

    }

    </script>

<div id="menulist"><select id="select_id">
        <?php foreach ($menu as $option) { ?>
            <option value="<?php echo $option->id?>"><?php echo $option->name?></option>
        <?php }?>

    </select>
    <a href="javascript:addDoc()" class="btn">创建文档</a>
<!--    <input type="button" value="添加" id="add"/>-->
    <br />
</div>

<br/>
<br/>

<table border="1">
    <tr>
        <th>文档类型</th>
        <th>编号</th>
        <th>版本号</th>
        <th>操作</th>
        <th>时间</th>
        <th>创建者</th>
    </tr>
    <?php
    $preRecord = "";
    foreach ($revisionlist as $revision) {
        ;
        ?>
        <tr>

            <?php if($preRecord != $revision["record"]) { $firstIndex = 1;?>
            <td>

                    <?php echo $typelist[$revision["type_id"]];?>

            </td>

            <td>
                <?php echo $revision["record"]?>
            </td>

            <?php }else{ $firstIndex = 0; echo "<td></td><td></td>"; }  $preRecord = $revision["record"]; ?>

            <td>
                <?php if($firstIndex == 1) {?>
                <a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/fileList/revisionId/<?php echo $revision['revisionId'] ?>">
                <?php echo $revision["revision"]?>
                </a>
                <?php } else{ echo $revision["revision"]; }?>


            </td>

            <td>
                <?php if($firstIndex == 1 && (Yii::app()->user->getRole()!= 2)) {?>
                    <a class="btn" href="javascript:updateRevison(<?php echo $revision["type_id"]?>,<?php echo $revision["recordId"]?>)">升级</a>
                    <a class="btn" href="javascript:delRevison(<?php echo $revision["revisionId"]?>,<?php echo $revision["recordId"]?>)">删除</a>
                <?php }?>
            </td>

            <td>
                <?php echo $revision["create_time"]?>
            </td>
            <td>
                <?php echo $userlist[$revision["user_id"]]?>
            </td>
        </tr>
    <?php }?>
</table>