<?php @header('Content-type: text/html;charset=UTF-8'); ?>


<h1>Welcome to configure System</h1>

<iframe src="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/navi" width="150" height="400"></iframe>
  
<iframe src="<?php echo Yii::app()->request->hostInfo.Yii::app()->baseUrl ?>/configure/docIndex" width="750" height="400" name="showFrame"></iframe>

<noframes>
<body>您的浏览器无法处理框架！</body>
</noframes>