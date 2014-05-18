<p>
 <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
 <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-small">添加管理员</a>
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
        array('name' => 'username'),
        array('name' => 'role_id','value'=>'$data->role->name'),
        array('name' => 'last_login' , 'value' => 'date(\'Y-m-d H:i:s\',$data->last_login)', 'htmlOptions' => array('width' => '150px')),
        array('name' => 'created', 'value' => 'date(\'Y-m-d H:i:s\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
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