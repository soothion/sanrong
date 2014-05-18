<p>
    <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
    <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-small">添加团购</a>
</p>
<form class="form-inline search-form" method="get" action="<?php echo $this->createUrl('index') ?>">
    <input type="text" name="title" <?php if(isset($_GET['title'])): ?>value="<?php echo $_GET['title'] ?>"<?php endif; ?> class="input-medium" placeholder="商品名">
    <input type="text" class="form_datetime input-medium" name="s_time" <?php if (isset($_GET['s_time'])): ?>value="<?php echo $_GET['s_time'] ?>"<?php endif; ?>  placeholder="开始时间"> --- 
    <input type="text" class="form_datetime input-medium" name="e_time" <?php if (isset($_GET['e_time'])): ?>value="<?php echo $_GET['e_time'] ?>"<?php endif; ?>  placeholder="结束时间">
    <select name="seller_id">        
        <option value="0">请选择商家</option>
        <?php foreach($sellerModel as $v): ?>
        <option <?php if(isset($_GET['seller_id']) && $_GET['seller_id'] == $v->id): ?>selected="selected"<?php endif; ?> value="<?php echo $v->id ?>"><?php echo $v->name ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn">搜索</button>
</form>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'bordered',
    'dataProvider' => $dataProvider,
    'enableSorting' => false,
    //'template' => "{items}",
    'summaryText' => '',
    'selectableRows' => 2,
    'columns' => array(
        array(
            'selectableRows' => 2,
            'class' => 'CCheckBoxColumn',
            'headerHtmlOptions' => array('width' => '30'),
            'checkBoxHtmlOptions' => array('name' => 'selected[]'),
        ),
        array('name' => 'id'),
        array('name' => 'title', 'htmlOptions' => array('width' => '')),
        array('name' => 's_time', 'value' => 'date(\'Y-m-d\',$data->s_time)'),
        array('name' => 'e_time', 'value' => 'date(\'Y-m-d\',$data->e_time)'),
        array('name' => 'g_price'),
        array('name' => 'created', 'value' => 'date(\'Y-m-d\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'htmlOptions' => array('width' => '50px'),
        ),
    ),
    'pager' => array(
        'maxButtonCount' => 10,
        'cssFile' => false,
        'header' => '',
    ),
));
?>
<script type="text/javascript" src="/static/jquery/jquery.js"></script><link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script>
        $(".form_datetime").datetimepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
        function poset_selected(url) {
            ajaxPost(url, $("input[name='selected[]']").serialize(), '', 'successfun');
        }
        function delete_selected() {
            data = {
                url: "<?php echo $this->createUrl('delete'); ?>",
                unselectedErrorMsg: "",
                confirmMsg: "确定要删除所选吗？",
                callback: "successfun"
            };
            sys_delete_selected(data);
        }
        function successfun() {
            setTimeout('location.reload();', 1000);
        }
        function deleteSuccess() {
            setTimeout('location.reload();', 1000);
        }
</script>

