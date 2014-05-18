<div class='main'>
    <div class='wrap'>
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>
            <?php
            $isEdit = !empty($model->id);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'id-form',
                'action' => $this->createUrl('extracurricular_save'),
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
            <div class="my_des">
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
                <?php echo $form->textArea($model, 'extracurricular') ?>
                注：可填写个人参加校内外活动，大学四年所读书籍
                <input name="" type="submit" value="提交"  class="submit_btn" />
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <?php echo $this->renderPartial('../common/fr') ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datePicker({
            clickInput: true,
            startDate: '1900-01-01'
        });
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
//    UE.getEditor('UserResumeModel_extracurricular', {
//        imagePath: "",
//        imageUrl: "<?php echo $this->createUrl('upload/ue_upload_image'); ?>",
//        //关闭字数统计
//        wordCount: false,
//        //关闭elementPath
//        elementPathEnabled: false,
//        //默认的编辑区域高度
//        initialFrameHeight: 300,
//        initialFrameWidth: 600
//                //更多其他参数，请参考ueditor.config.js中的配置项
//    })
</script>

