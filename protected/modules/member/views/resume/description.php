<div class='main'>
    <div class='wrap'>
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>
            <?php
            $isEdit = !empty($model->id);
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'id-form',
                'action' => $this->createUrl('description_save'),
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
                <?php echo $form->textArea($model, 'description') ?>
                <div>
                    范例：<br/>
                    1、五年以上外资大型制造企业采购专业从业经验，从事过中大型项目工程建设，熟悉物资采购和工程招投标流程，了解仪电和机械行业供应商资源；<br/>
                    2、有一定的材料、机械、设备、仪电等专业知识，了解生产工艺流程，熟悉公司生产所需物料；<br/>
                    3、三年仪控工程项目管理经验，对材料设备的成本控制、预结算等环节进行管控，了解相关财务、合同法知识；<br/>
                    4、熟悉询价、比价、签订采购合同，验收、评估及反馈工作；参与招标的有关活动及项目开标、评标、议标和答疑会，并能进行资源整合，提出定标意见。供应商和承包商开发及考核、管理；<br/>
                    5、熟练应用办公软件及CAD制图和SAP系统，具备良好部门内和跨部门的组织和协调能力，良好的谈判、人际沟通能力，成本意识和团队协作能力强。<br/>
                </div>
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
//    UE.getEditor('UserResumeModel_description', {
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

