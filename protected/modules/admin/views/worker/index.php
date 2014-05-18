<p>
    <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
    <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-small">添加业务员</a>
</p>
<form class="form-inline search-form" method="get" action="<?php echo $this->createUrl('index') ?>">
    <input type="text" name="id" <?php if (isset($_GET['id'])): ?>value="<?php echo $_GET['id'] ?>"<?php endif; ?> class="input-medium" placeholder="编号">
    <input type="text" name="username" <?php if (isset($_GET['username'])): ?>value="<?php echo $_GET['username'] ?>"<?php endif; ?> class="input-medium" placeholder="用户名">

    <select name="status">        
        <option value="-1">状态</option>
        <?php foreach(WorkerModel::model()->get_status_arr() as $k=>$v): ?>
        <option <?php if(isset($_GET['status']) && $_GET['status'] == $k): ?>selected="selected"<?php endif; ?> value="<?php echo $k ?>"><?php echo $v ?></option>
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
        array('name' => 'id', 'value' => 'get_worker_id($data->id)'),
        array('name' => 'mobile'),
        array('name' => 'username'),
        array('name' => 'status', 'value' => 'WorkerModel::model()->get_status_arr($data->status)'),
        array('name' => 'last_login', 'value' => '$data->last_login == 0? "" :date(\'Y-m-d H:i:s\',$data->last_login)', 'htmlOptions' => array('width' => '150px')),
        array('name' => 'created', 'value' => 'date(\'Y-m-d H:i:s\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{worker_info} {update} {delete}',
            //'deleteConfirmation'=>false,
            'buttons' => array(
                'worker_info' => array('label' => '工作记录管理', 'icon' => 'icon-th', 'url' => 'Yii::app()->controller->createUrl("worker_info",array("worker_id"=>$data->primaryKey))'),
            ),
            'htmlOptions' => array('width' => '70px'),
        ),
    ),
    'pager' => array(
        'maxButtonCount' => 10,
        'cssFile' => false,
        'header' => '',
    ),
));
?>
<script>
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