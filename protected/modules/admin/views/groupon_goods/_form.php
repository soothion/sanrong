<style type="text/css">
    .relation_contain{
        margin-top: 30px;
    }
    #search_res{float:left}
    #search_res select,#relation_res select{width:300px;height:400px;}
    #relation_res{float:left}
    .operate_even{width:100px;height:370px;border:1px solid #CCC;margin:0px 20px;float:left;padding-top:30px;}
    .operate_even p{text-align: center;padding:10px 0px;}

</style>
<?php
$isEdit = !empty($model->id);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'id-form',
    'type' => 'horizontal',
    'action' => $this->createUrl('save'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:afterValidate',
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onsubmit' =>'return checkRelationGoods()',
    ),
        ));
?>
<?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
<?php endif; ?>
<div class="tabbable" style="margin-bottom: 9px;">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#goods_main" data-toggle="tab">主要信息</a></li>
        <li class=""><a href="#goods_relation" data-toggle="tab">关联商品</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="goods_main">
            <?php echo $form->textFieldRow($model, 'title', array()); ?>
            <?php echo $form->textAreaRow($model, 'summary', array('rows' => 5, 'class' => 'input-xxlarge')) ?>
            <?php echo $form->dropDownListRow($model, 'seller_id', GrouponGoodsModel::model()->get_seller()) ?>
            <?php echo $form->dropDownListRow($model, 'area', GrouponGoodsModel::model()->get_area(), array('multiple' => 'multiple', 'size' => '10')) ?>
            <?php echo $form->dropDownListRow($model, 'cate_id', GrouponGoodsModel::model()->get_cate()) ?>
            <?php echo $form->dropDownListRow($model, 'subject_id', GrouponGoodsModel::model()->get_subject()) ?>
            <?php echo $form->textFieldRow($model, 's_time', array('class' => 'form_datetime')); ?>
            <?php echo $form->textFieldRow($model, 'e_time', array('class' => 'form_datetime')); ?>
            <?php echo $form->textFieldRow($model, 'virtual_salenum', array()); ?>
            <?php echo $form->radioButtonListInlineRow($model, 'is_recommend', GrouponGoodsModel::model()->get_boolean_arr()); ?>
            <?php echo $form->radioButtonListInlineRow($model, 'is_top', GrouponGoodsModel::model()->get_boolean_arr()); ?>
            <?php echo $form->dropDownListRow($model, 'status', GrouponGoodsModel::model()->get_status()) ?>
            <div class="control-group ">
                <label class="control-label" for="GrouponGoodsModel_image">图片</label>
                <div class="controls">
                    <input id="ytGrouponGoodsModel_image" type="hidden" value="" name="image">
                    <input name="image" id="GrouponGoodsModel_image" type="file">
                    <span class="help-inline error" id="GrouponGoodsModel_image_em_" style="display: none"></span>
                </div>
            </div>
            <?php if ($model->image != ''): ?>
                <div class="control-group ">
                    <label class="control-label" for="GrouponGoodsModel_image"></label>
                    <div class="controls">
                        <img src="<?php echo getImageUrl($model->image); ?>" width="100" /> <br />
                        <input type="checkbox" name="delete_image" value="1" />
                        删除图片
                    </div>
                </div>
            <?php endif; ?>
            <?php echo $form->textFieldRow($model, 'm_price', array()); ?>
            <?php echo $form->textFieldRow($model, 'g_price', array()); ?>
            <?php echo $form->textFieldRow($model, 'views', array()); ?>
            <?php echo $form->textAreaRow($model, 'content', array()); ?>
            <?php echo $form->textAreaRow($model, 'tip', array()); ?>
            <?php echo $form->textFieldRow($model, 'feature', array()); ?>
        </div>
        <div class="tab-pane" id="goods_relation">
            <input type='text' id='goods_name' placeholder="商品名称" />
            <select id="groupon_seller" class="input-large">
                <option value="0">全部商家</option>
                <?php foreach (GrouponSellerModel::model()->findAll() as $k => $v): ?>
                    <option value="<?php echo $v->id ?>"><?php echo $v->name ?></option>
                <?php endforeach ?>
            </select>
            <a href='javascript:void(0)' id='searchGoods' class='btn' onclick="searchGoods()">搜索</a>
            <div class="relation_contain">
                <div id='search_res'>
                    <select multiple='multiple' id="search_goods_id" ondblclick='give_relation(this)'>
                    </select> 
                </div>
                <div class='operate_even'>
                    <p><a href="javascript:;" id='add' class='btn'> > </a></p>
                    <p><a href="javascript:;" id='remove' class='btn'> < </a></p>
                    <p><a href="javascript:;" id='add_all' class='btn'> >> </a></p>
                    <p><a href="javascript:;" id='remove_all' class='btn'> << </a></p>
                </div>
                <div id='relation_res'>
                    <select name="GrouponGoodsModel[relation_goods_id][]" id="relation_goods_id" multiple="multiple">
                        <?php if($isEdit): ?>
                            <?php foreach($relation_goods as $k=>$v): ?>
                        <option value="<?php echo $v->id ?>"><?php echo $v->title ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => ' 保 存 ', 'url' => $this->createUrl('save'))); ?>
</div>
<?php $this->endWidget(); ?>
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
                        function afterValidate(form, data, hasError) {
                            if (hasError == false) {
                                ajaxFormSubmit("#id-form", 'successfun');
                            }
                            return false;
                        }
                        ;
                        function successfun(data) {
                            setTimeout("history.go(-1);", 1000);
                        }
                        UE.getEditor('GrouponGoodsModel_content', {
                            imagePath: "",
                            imageUrl: "<?php echo $this->createAbsoluteUrl('upload/ue_upload_image'); ?>",
                            //关闭字数统计
                            wordCount: false,
                            //关闭elementPath
                            elementPathEnabled: false,
                            //默认的编辑区域高度
                            initialFrameHeight: 300,
                            initialFrameWidth: 600
                                    //更多其他参数，请参考ueditor.config.js中的配置项
                        });
                        UE.getEditor('GrouponGoodsModel_tip', {
                            imagePath: "",
                            imageUrl: "<?php echo $this->createAbsoluteUrl('upload/ue_upload_image'); ?>",
                            //关闭字数统计
                            wordCount: false,
                            //关闭elementPath
                            elementPathEnabled: false,
                            //默认的编辑区域高度
                            initialFrameHeight: 300,
                            initialFrameWidth: 600
                                    //更多其他参数，请参考ueditor.config.js中的配置项
                        });
                        //imageUploader.setPostParams({
                        //    "action": "/project/upload/up.php"
                        //});
                        //搜索商家
                        function searchGoods() {
                            var goods_name = $('#goods_name').val();
                            var seller_id = $('#groupon_seller').val();
                            <?php if($isEdit): ?>
                            var goods_id = <?php echo $model->id ?>;
                            <?php else: ?>
                            var goods_id = 0;
                            <?php endif; ?>
                            $.post("<?php echo $this->createUrl('groupon_goods/search_goods_ajax') ?>", {seller_id: seller_id, goods_name: goods_name,goods_id:goods_id}, function(data) {
                                var _res = "";
                                $.each(data, function(k, v) {
                                    _res += "<option value='" + v.id + "'>" + v.title + "</li>"
                                });
                                $('#search_goods_id').html(_res);
                            }, 'json');
                        }


</script>
<script type="text/javascript">
    function checkRelationGoods(){
        $('#relation_goods_id option').attr('selected','selected');
        return true;
    }
    $(function() {
        $('#search_goods_id').dblclick(function() {
            $("option:selected", this).appendTo('#relation_goods_id');
        });
        $('#relation_goods_id').dblclick(function() {
            $("option:selected", this).appendTo('#search_goods_id');
        });
        
        $('#add').click(function() {
            $('#search_goods_id option:selected').appendTo('#relation_goods_id');
        });
        $('#remove').click(function() {
            $('#relation_goods_id option:selected').appendTo('#search_goods_id');
        });
        $('#add_all').click(function() {
            $('#search_goods_id option').appendTo('#relation_goods_id');
        });
        $('#remove_all').click(function() {
            $('#relation_goods_id option').appendTo('#search_goods_id');
        });
    });
</script>
