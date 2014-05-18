<p>
    <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
    <?php if(isset($worker_id)): ?>
    <a href="<?php echo $this->createUrl('worker_info_create', array('worker_id' => $worker_id)); ?>" class="btn btn-small">添加工作记录</a>
    <?php endif; ?>
</p>
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
        array('name'=>'worker_id','value'=>'get_worker_id($data->worker_id)'),
        array('name' => '业务员', 'value' => '$data->worker->username'),
        array('name' => 'content', 'htmlOptions' => array('width' => '30%')),
        array('name' => 'score'),
        array('name' => 'status', 'value' => 'WorkerInfoModel::model()->getStatus($data->status)', 'htmlOptions' => array()),
        array('name' => 'operated', 'value' => 'date(\'Y-m-d\',$data->operated)'),
        array('name' => 'created', 'value' => 'date(\'Y-m-d H:i:s\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete} {appeal}',
            //'deleteConfirmation'=>false,
            'buttons' => array(
                'update' => array('label' => '修改', 'icon' => 'icon-pencil', 'url' => 'Yii::app()->controller->createUrl("worker_info_update",array("id"=>$data->primaryKey))'),
                'delete' => array('label' => '删除', 'icon' => 'icon-trash', 'url' => 'Yii::app()->controller->createUrl("worker_info_delete",array("id"=>$data->primaryKey))'),
                'appeal' => array('label' => '查看申诉信息', 'icon' => 'icon-eye-open','url'=>'Yii::app()->controller->createUrl("worker_appeal",array("id"=>$data->primaryKey))'),
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
            url: "<?php echo $this->createUrl('worker_info_delete'); ?>",
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
    $(function(){
        $.each($('tr'),function(k,v){
            if($(this).find('td:eq(5)').text().indexOf('申诉中') != -1){
                $(this).find('td:eq(5)').css('color','red');
            }
        });
    });
</script>