<p>
 <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
 <a href="<?php echo $this->createUrl('role_create'); ?>" class="btn btn-small">添加角色</a>
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
        array('name' => 'name'),
        array('name' => 'desc'),
        array('name' => 'created', 'value' => 'date(\'Y-m-d\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("role_update",array("id"=>$data->primaryKey))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("role_delete",array("id"=>$data->primaryKey))',
			//'deleteConfirmation'=>false,
            'htmlOptions' => array('width' => '50px'),
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
		url:"<?php echo $this->createUrl('role_delete');?>",
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