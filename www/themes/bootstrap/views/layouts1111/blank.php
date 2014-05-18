<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/static/jquery/jquery.form.js"></script>
        <?php Yii::app()->bootstrap->register(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" media="all" />
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/static/js/common.js"></script>

    </head>

    <body>
        <div id="login">
            <?php echo $content; ?>
        </div>
    </body>
</html>