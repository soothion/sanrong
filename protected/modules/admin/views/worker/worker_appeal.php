<p><a class='btn btn-small' href='<?php echo $this->createUrL('/admin/worker/worker_info',array('worker_id'=>$workerInfoModel->worker_id)) ?>'>返回</a></p>
<p style='margin-top: 15px;'>申诉的记录信息：</p>
<div id="yw0" class="grid-view">
    <div class="summary"></div>
    <table class="items table table-bordered">
        <thead>
            <tr>                
                <th id="yw0_c1">业务员编号</th>
                <th id="yw0_c2">业务员</th>
                <th id="yw0_c3">工作记录</th>
                <th id="yw0_c4">积分</th>
                <th id="yw0_c5">申诉状态</th>
                <th id="yw0_c6">操作时间</th>
                <th id="yw0_c7">创建时间</th>
<!--                <th class="button-column" id="yw0_c8">&nbsp;</th>-->
            </tr>
        </thead>
        <tbody>
            <tr class="odd">                
                <td><?php echo get_worker_id($workerInfoModel->worker_id) ?></td>
                <td><?php echo $workerInfoModel->worker->username ?></td>
                <td width="30%"><?php echo $workerInfoModel->content; ?></td>
                <td>￥<?php echo $workerInfoModel->score ?></td>
                <td><?php echo WorkerInfoModel::model()->getStatus($workerInfoModel->status); ?></td>
                <td><?php echo date('Y-m-d', $workerInfoModel->operated); ?></td>
                <td width="150px"><?php echo date('Y-m-d H:i:s', $workerInfoModel->created); ?></td>
<!--                <td width="50px">
                    <a class="update" title="回复" rel="tooltip" href="/admin/worker/worker_info_update/id/8.html">
                        <i class="icon-edit"></i>
                    </a> 
                </td>-->
            </tr>
        </tbody>
    </table>
</div>
<p style='margin-top: 15px;'>内容：</p>
<div id="yw0" class="grid-view">
    <div class="summary"></div>
    <?php foreach ($model as $k => $v): ?>
        <table class="items table table-bordered">
            <tbody>
                <tr class="">                
                    <td>
                            <?php if(numeric($v->admin_id) > 0): ?>
                                    <?php echo $v->admin_name."回复：".$v->content ?>
                                    <?php else: ?>
                        <?php echo '用户申诉：'.$v->content; ?>
                            <?php endif; ?>
                        
                    </td>
                    <td width="20%">
                        <?php echo date('Y-m-d H:i:s', $v->created) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
    <?php
    $isEdit = !empty($model->id);
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'id-form',
        'type' => 'horizontal',
        'action' => $this->createUrl('worker_appeal_save'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:afterValidate',
        ),
    ));
    ?>
    <input type="hidden" name="worker_info_id" value="<?php echo $workerInfoModel->id ?>" />
    <input type="hidden" name="worker_id" value="<?php echo $workerInfoModel->worker_id ?>" />
    <?php echo $form->textAreaRow($replyModel, 'content', array('rows' => 5, 'class' => 'input-xxlarge')) ?>
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => '回 复', 'url' => $this->createUrl('save'))); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
function afterValidate(form, data, hasError){
	if(hasError==false){
		ajaxFormSubmit("#id-form",'successfun');
	}
	return false;
};
function successfun(data){
	setTimeout("history.go(-1);",1000);
}
UE.getEditor('GrouponSellerModel_introduce',{
	imagePath:"",
	imageUrl:"<?php echo $this->createUrl('upload/ue_upload_image');?>",
	//关闭字数统计
	wordCount:false,
	//关闭elementPath
	elementPathEnabled:false,
	//默认的编辑区域高度
	initialFrameHeight:300,
        initialFrameWidth:600
	//更多其他参数，请参考ueditor.config.js中的配置项
})
imageUploader.setPostParams({
    "action":"/project/upload/up.php"
});
</script>
