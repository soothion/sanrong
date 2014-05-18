<p>
 <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
<!--  <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-small">添加新闻</a>-->
</p>
<!--<form class="form-inline search-form" method="get" action="<?php echo $this->createUrl('index') ?>">
    <input type="text" name="title" <?php if (isset($_GET['title'])): ?>value="<?php echo $_GET['title'] ?>"<?php endif; ?> class="input-medium" placeholder="标题">
    <button type="submit" class="btn">搜索</button>
</form>-->
<!--<Br/>
<form class="form-inline" method="get" action="<?php echo $this->createUrl('list') ?>">
  <select id="BillsModel_house_id" class="input-large" name="house_id"></select>
  <select id="BillsModel_room_id" class="input-large" name="room_id"></select>
  <button type="submit" class="btn">搜索</button>
</form>-->
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
        array('name' => 'goods_id'),
        array('name' => '商品名称', 'value'=>'$data->order_goods->goods_name'),
        array('name' => '评论者', 'value'=>'$data->orders->user_email'),
        array('name' => 'content'),
        array('name' => 'stars'),
        array('name' => 'created', 'value' => 'date(\'Y-m-d\',$data->created)', 'htmlOptions' => array('width' => '150px')),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
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

