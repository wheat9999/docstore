<?php @header('Content-type: text/html;charset=UTF-8'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/docstore.css" />

<table border="1">
    <tr>
        <th>文档类型</th>
        <th>文档编码</th>
    </tr>
    <?php foreach ($data as $docType) {
        ;
        ?>
        <tr>

            <td>
                <a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/propertyconfig/typeId/<?php echo $docType->id?>">
                <?php echo $docType->name?>
                </a>
            </td>

            <td>
                <a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/ruleDetail/typeId/<?php echo $docType->id?>" class="btn">
                <?php echo strlen($docType->rule) == 0 ?"新建":"更新"?>
                </a>
            </td>
        </tr>
    <?php }?>
</table>