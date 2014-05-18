<!--主体开始-->
<div class="wrap">
    <!--筛选器开始-->
    <div class="rc_s">
        <div class="rc_s_tit">
            <h1>业务申诉</h1>
            <p>业务员编号：<?php echo Yii::app()->user->id; ?>&nbsp;&nbsp;业务员姓名：<?php echo Yii::app()->user->getState('username'); ?>&nbsp;&nbsp;</p>
        </div>
        <div class="rc_s_con">
            <!--本页只展示当前选择的申诉的记录信息，用来展示。这里的状态是针对"申诉"来讲的，分为：正常（发布后及正常）；申诉中，等待回复；申诉中，已回复；申诉失败；申诉成功。-->
            <table class="order_list yw_jl">
                <tr>
                    <th style="width:10%;">编号</th>
                    <th style="width:15%;">时间</th>
                    <th style="width:55%;">内容</th>
                    <th style="width:10%;">积分</th>
                    <th style="width:10%;">状态</th>
                </tr>

                <tr>
                    <td><?php echo Yii::app()->user->id; ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $workerInfoModel->created); ?></td>
                    <td><?php echo $workerInfoModel->content; ?></td>
                    <td>￥<?php echo $workerInfoModel->score ?>  </td>
                    <td><?php echo WorkerInfoModel::model()->getStatus($workerInfoModel->status) ?></td>
                </tr>
            </table>
            <div class="ss_list">
                <?php if (count($info)): ?>
                    <?php foreach ($info as $k => $v): ?>
                        <?php if (numeric($v->admin_id) == 0): ?>
                            <div class="ss_list_con">
                                <div class="ss_tit"><b><?php echo Yii::app()->user->getState('username'); ?></b> 于 <?php echo date('Y-m-d H:i:s', $v->created) ?></div>
                                <div class="ss_des">
                                    <?php echo $v->content ?>
                                </div>
                            </div>
                        <?php elseif (numeric($v->admin_id) > 0): ?>
                            <div class="ss_list_con">
                                <div class="ss_tit bc666"><?php echo date('Y-m-d H:i:s',$v->created); ?> 来自于 客服<?php echo $v->admin_name ?></div>
                                <div class="ss_des">
                                    <?php echo $v->content ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="ss_text">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'id-form',
                        'action' => $this->createUrl('appeal'),
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
                    <div class="ss_text_tit">申诉内容</div>
                    <div class="ss_text_des"><?php echo $form->textArea($model, 'content') ?></div>
                    <div class="ss_text_btn"><input name="" type="submit" value="提交" /></div>
                    <input type="hidden" name='worker_info_id' value='<?php echo $workerInfoModel->id; ?>' />
                    <?php $this->endWidget(); ?>
                </div>
            </div>


        </div>
    </div>
</div>
<!--主体结束-->
<script type="text/javascript">
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