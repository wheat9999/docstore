<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />

<script
    src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>
    $(document).ready(function() {


        $("#add").click(function () {


            var index = 0;
            var text = "";

            $("[id^='input_']").each(function() {

              var name =  $(this).attr("name");
              var input = $(this).val();



              var keyValue = name+"$&$"+input;



                if(index == 0)
                {
                    text += keyValue;
                }
                else {
                    text += "#&#" + keyValue;
                }

                index ++;

            });



            $.ajax({
                type:'Get',
                url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/save',
                data:{typeId:<?php echo $typeId ?>, inputs:text},
                dataType:"json",
                cache : false,
                success:function(msg){


                    window.location.href = '<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/doc/list';

                }

            });

        });
    });

    </script>

<h3>创建一个文档</h3>

<br/>
<?php foreach($fieldArray as $field) {

    if($field["type"]==2){?>
        <input type="hidden" id="input_<?php echo $field["id"]?>" name="<?php echo $field["id"]?>" value="#*#"/>

    <?php } elseif($field["type"] == 0){ echo $field["name"]; ?>
        <input type="text" id="input_<?php echo $field["id"]?>" name="<?php echo $field["id"]?>"/>

     <?php }elseif($field["type"] == 1){ echo $field["name"];?>

        <select id="input_<?php echo $field["id"]?>" name="<?php echo $field["id"]?>">
          <?php $index = 0;  foreach($menuList[$field["id"]] as $menu) {?>
            <option value="<?php echo $menu["key"] ?>"  <?php if($index == 0) echo "selected"?> ><?php echo $menu["value"];$index++ ?></option>

            <?php }?>
        </select>

         <?php } ?>
    <br/>



<?php }?>

<input type="button" value="添加" id="add" />