<p>
 <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
 <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-small">添加用户</a>
</p>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'bordered',
    'dataProvider' => $dataProvider,
    'enableSorting' => false,
    //'template' => "{items}",
	'summaryText'=>'',
    'selectableRows' => 2,
    'columns' => array(
        array(
            'selectableRows' => 2,
            'class' => 'CCheckBoxColumn',
            'headerHtmlOptions' => array('width' => '30'),
            'checkBoxHtmlOptions' => array('name' => 'selected[]'),
        ),
        array('name' => 'id'),
        array('name' => 'mobile'),
        array('name' => 'email'),
        array('name' => 'user_type','value'=>'UserModel::model()->get_user_type($data->user_type)'),
        array('name' => 'status','value'=>'UserModel::model()->get_status($data->status)'),
        array('name' => 'last_login' , 'value' => '$data->last_login == 0? "" :date(\'Y-m-d H:i:s\',$data->last_login)', 'htmlOptions' => array('width' => '150px')),
        array('name' => 'created', 'value' => 'date(\'Y-m-d H:i:s\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{worker_info} {update} {delete}',
			//'deleteConfirmation'=>false,
            'buttons'=>array(
                'worker_info'=>array('label'=>'查看用户信息','icon'=>'icon-th','url'=>'Yii::app()->controller->createUrl("user_info",array("user_id"=>$data->primaryKey))'),
            ),
            'htmlOptions' => array('width' => '70px'),
        ),
    ),
	'pager'=>array(  
                'maxButtonCount'=>10,
				'cssFile'=>false,
				'header'=>'',
                ),  
));
?>
<script>
function poset_selected(url){
	ajaxPost(url,$("input[name='selected[]']").serialize(),'','successfun');
}
function delete_selected(){
	data = {
		url:"<?php echo $this->createUrl('delete');?>",
		unselectedErrorMsg:"",
		confirmMsg:"确定要删除所选吗？",
		callback:"successfun"
		};
	sys_delete_selected(data);
}
function successfun(){
	setTimeout('location.reload();',1000);
}
function deleteSuccess(){
	setTimeout('location.reload();',1000);
}
</script>