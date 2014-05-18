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
                            <td style="text-align:left;"><span><?php echo UserPurposeModel::model()->apply_job_type_arr($v->apply_job_type_id) ?></span><span></span><span></span></td>
                            <td><a href="<?php echo $this->createUrl('purpose_update', array('id' => $v->id)) ?>" class="evaluate_btn evaluate_edit">修改</a></td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php
            $isEdit = !empty($model->id);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'id-form',
                'action' => $this->createUrl('purpose_save'),
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
            <?php else: ?>
                <style type="text/css">
                    .full-time,.part-time{display:none}
                </style>
            <?php endif; ?>
            <?php if ($isEdit && numeric($model->apply_job_type_id) > 1): ?>
                <style type="text/css">
                    .part-time{display:none}
                    .full-time{display: block}
                </style>
            <?php endif; ?>
            <?php if ($isEdit && numeric($model->apply_job_type_id) == 1): ?>
                <style type="text/css">
                    .full-time{display:none}
                    .part-time{display: block}
                </style>
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
                <li><b>求职类型</b><?php echo $form->dropDownList($model, 'apply_job_type_id', UserPurposeModel::model()->apply_job_type_arr(), array('prompt' => '请选择', 'id' => 'apply_job_type')); ?></li>
            </ul>
            <ul class="jl_xq full-time">
                
                <li><b>应聘职位</b><?php echo $form->dropDownList($model, 'resume_position_id', UserPurposeModel::model()->get_position(), array('prompt' => '请选择')); ?></li>
                <li><b>期待待遇</b><?php echo $form->dropDownList($model, 'wish_treatment_id', UserPurposeModel::model()->wish_treatment_arr(), array('prompt' => '请选择')); ?></li>
                <li><b>其他福利</b><?php echo $form->checkBoxList($model, 'other_weal', UserPurposeModel::model()->get_other_weal(), array('separator' => '&nbsp;')) ?></li>
                <li><b>期望工作地点</b><?php echo $form->dropDownList($model, 'wish_job_place_id', UserPurposeModel::model()->get_area(), array('prompt' => '请选择')); ?></li>
                <li><b>求职状态</b><?php echo $form->dropDownList($model, 'apply_job_status', UserPurposeModel::model()->apply_job_status_arr(), array('prompt' => '请选择')); ?></li>
                <li>帮助：保存完可填写下条求职意向</li>
                <div class="lbtn"><input name="" type="submit" value="提交"  class="submit_btn" /></div>
            </ul>
            <ul class="jl_xq part-time">
                <li><b>期待待遇</b><?php echo $form->dropDownList($model, 'wish_part_time_treatment_id', UserPurposeModel::model()->wish_part_time_treatment_arr(), array('prompt' => '请选择')); ?> 元/日</li>
                <li><b>期望类型</b><?php echo $form->checkBoxList($model, 'part_time_type', UserPurposeModel::model()->get_part_time_type(), array('separator' => '&nbsp;')) ?></li>
                <li>帮助：保存完可填写下条求职意向</li>
                <div class="lbtn"><input name="" type="submit" value="提交"  class="submit_btn" /></div>
            </ul>

            <?php $this->endWidget(); ?>
        </div>
        <?php echo $this->renderPartial('../common/fr') ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#apply_job_type').change(function() { 
            if ($(this).val() == 1) { 
                $('.part-time').show();
                $('.full-time').hide();
            } else if ($(this).val() == '') {
                $('.part-time').hide();
                $('.full-time').hide();
            } else {
                $('.part-time').hide();
                $('.full-time').show();
            }
        });
        
    })
//    $(document).ready(function() {
//        $(".datepicker").datePicker({
//            clickInput: true,
//            startDate: '1900-01-01'
//        });
//    });
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

