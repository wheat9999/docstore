<?php @header('Content-type: text/html;charset=UTF-8'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<script>

    $(document).ready(function() {

            $("#user_add").click(function ()
            {
                var login = $("#user_name").val();

                var permission=$("#select_id").find("option:selected").val();

                $.ajax({
                    type:'Get',
                    url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/addUser',
                    data:{login:login, permission:permission},
                    dataType:"json",
                    cache : false,
                    success:function(msg){

                        window.location.reload();

                    }
                });



            });
        });

    function delUser(userId)
    {

        $.ajax({
            type:'Get',
            url:'<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/delUser',
            data:{userId:userId},
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
        <th>用户名</th>
        <th>用户权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($userlist as $user) {
        ;
        ?>
        <tr>

            <td>
                   <?php echo $user['login']?>

            </td>

            <td>
                <?php if($user['permission'] ==0)
                      echo '管理员';
                     elseif($user['permission'] ==1)
                         echo '操作员';
                     else
                         echo '游客';

            ?>
            </td>
            <td>
                <a href="javascript:delUser(<?php echo $user['id'];?>)" class="btn">
                    删除
                </a>
            </td>
        </tr>
    <?php }?>
</table>

<br/>
<br/>
<h3>新增用户(初始密码123)</h3>

<br/>
<div id="add-type">
    登陆名:
    <input type="text"  id="user_name"/>

    权限:
    <select id="select_id">
        <option value="2" selected>游客</option>
        <option value="1" >操作员</option>
        <option value="0" >管理员</option>
    </select>

    <input type="button" id="user_add" value="新增"/>

</div>