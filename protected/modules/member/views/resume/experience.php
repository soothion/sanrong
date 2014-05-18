<link href="/static/js/bootstrap-datetimepicker/v2/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="/static/js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<div class='main'>
    <div class='wrap'>
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>

            <?php if (isset($All_model) && !empty($All_model)): ?>
                <?php foreach ($All_model as $k => $v): ?>
                    <table class="order_list module_table">
                        <tr>
                            <th style="width:90%;">内容</th>
                            <th style="width:10%;">操作</th>
                        </tr>
                        <tr>
                            <td style="text-align:left;"><span><?php echo date('Y-m', $v->from_time) ?>-<?php echo date('Y-m', $v->to_time) ?></span><span><?php echo $v->company_name ?></span><span><?php echo $v->position ?></span></td>
                            <td><a href="<?php echo $this->createUrl('experience_update', array('id' => $v->id)) ?>" class="evaluate_btn evaluate_edit">修改</a></td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php
            $isEdit = !empty($model->id);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'id-form',
                'action' => $this->createUrl('experience_save'),
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'afterValidate' => 'js:afterValidate',
                ),
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                ),
            ));
            ?>
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
            <?php endif; ?>
            <ul class="jl_xq">
                <div class="log_res">
                    <?php
                    if (isset($log_res)) {
                        echo "<span class='log_status'>".$log_res['status']."</span>";
                        if(!empty($log_res['info'])){
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;<span class='log_reason'>失败原因：".$log_res['info']."</span>";
                        }
                    }
                    ?>
                </div>
                <li><b>起始时间</b><?php echo $form->textField($model, 'from_time', array('class' => 'datepicker')) ?></li>
                <li><b>结束时间</b><?php echo $form->textField($model, 'to_time', array('class' => 'datepicker')) ?></li>
                <li><b>工作单位</b><?php echo $form->textField($model, 'company_name') ?></li>
                <li><b>所任职位</b><?php echo $form->textField($model, 'position') ?></li>
                <li><b>上传名片</b><input type="file" name="business_card" id="" />（zip包）<?php if (isset($model->business_card) && !empty($model->business_card)): ?><a href="<?php echo $model->business_card ?>">下载</a><?php endif; ?></li>
                <li class="text"><b>工作亮点</b><?php echo $form->textArea($model, 'work_highlight') ?></li>
                <li>帮助：保存完可填写下条工作经历</li>
                <div class="lbtn"><input name="" type="submit" value="提交"  class="submit_btn" /></div>
            </ul>
            <?php $this->endWidget(); ?>
        </div>
        <?php echo $this->renderPartial('../common/fr') ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker/v3/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.datepicker').datetimepicker({
        language: 'zh-CN',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 3,
        minView: 3,
        forceParse: 0,
        format: 'yyyy-mm'
    });
    function afterValidate(form, data, hasError) {
        if (hasError == false) {
            ajaxFormSubmit("#id-form", 'successfun');
        }
        return false;
    }
    ;
    function successfun(data) {
        setTimeout("location.href='" + data.goUrl + "';", 1000);
    }
</script>