<!--<p>
 <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
 <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-small">添加用户</a>
</p>-->
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
        array('name' => '姓名', 'value' => '$data->company->real_name'),
        array('name' => '公司名称', 'value' => '$data->company->company_name'),
        array('name' => '职务', 'value' => '$data->company->position'),
        array('name' => '公司地址', 'value' => '$data->company->company_address'),
        array('name' => '手机', 'value' => '$data->mobile'),
        array('name' => '邮箱', 'value' => '$data->email'),
        array('name' => '公司固话', 'value' => '$data->company->company_phone'),
        array('name' => '营业执照（图）', 'value' => 'UserCompanyModel::model()->get_trading_certificate($data->company->id)'),
        array('name' => 'created', 'value' => 'date(\'Y-m-d H:i:s\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => ' {update} ',
            'buttons' => array(
                'update' => array('label' => '修改', 'icon' => 'icon-pencil', 'url' => 'Yii::app()->controller->createUrl("company_info_update",array("id"=>$data->company->id))'),
            ),
            //'deleteConfirmation'=>false,
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
<?php if (!empty($model->company->trading_certificate)): ?>
    <img src="<?php echo $model->company->trading_certificate ?>" alt="" />
<?php endif; ?>
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