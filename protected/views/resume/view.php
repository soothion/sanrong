<!--主体开始-->
<div class="wrap">
    <!--筛选器开始-->
    <div class="rc_s">
        <div class="rc_s_tit">
            <h1>个人简历</h1>
            <p>简历编号：<?php echo get_resume_id($model->id) ?>  更新日期：<?php echo date('Y-m-d H:i:s', $model->updated) ?></p>
        </div>
        <div class="rc_s_con">
            <h2>基本资料</h2>
            <ul class="xx">
                <div class="xxcon">
                    <li><b>姓　　名：</b><?php echo $model->username; ?></li>
                    <li><b>性　　别：</b><?php echo UserResumeModel::model()->gender_arr($model->gender); ?></li>
                    <li><b>身　　高：</b><?php echo $model->height ?></li>
                    <li><b>体　　重：</b><?php echo $model->weight; ?></li>
                    <li><b>出生年月：</b><?php echo date('Y-m', $model->birthday) ?></li>
                    <li><b>视力状况：</b><?php echo UserResumeModel::model()->eyesight_arr($model->eyesight) ?></li>
                    <li><b>健康情况：</b><?php echo UserResumeModel::model()->healthy_arr($model->healthy) ?></li>
                    <li><b>政治面貌：</b><?php echo UserResumeModel::model()->political_status_arr($model->political_status) ?></li>
                    <li><b>婚姻状况：</b><?php echo UserResumeModel::model()->marry_arr($model->marry_status) ?></li>
                    <li><b>学　　历：</b><?php echo UserResumeModel::model()->education_arr($model->education) ?></li>
                    <li><b>年　　级：</b><?php echo UserResumeModel::model()->get_grade_arr($model->grade) ?></li>
                    <li><b>毕业院校：</b><?php echo $model->graduate_school ?></li>
                    <li><b>毕业时间：</b><?php echo date('Y-m-d', $model->graduate_time) ?></li>
                    <li><b>第一专业：</b><?php echo $model->major_first ? $model->major_first->name : "" ?></li>
                    <li><b>第二专业：</b><?php echo $model->major_second ? $model->major_second->name : "" ?></li>
                    <li><b>第一外语：</b><?php echo $model->foreign_lang_first ?></li>
                    <li><b>第二外语：</b><?php echo $model->foreign_lang_second ?></li>
                    <li><b>第一职称：</b><?php echo $model->technical_titles_first ? $model->technical_titles_first->name : '' ?></li>
                    <li><b>第二职称：</b><?php echo $model->technical_titles_second ? $model->technical_titles_second->name : '' ?></li>
                    <li><b>电脑水平：</b><?php echo UserResumeModel::model()->computer_level_arr($model->computer_level) ?></li>
                    <li><b>技能特长：</b><?php echo $model->resume_speciality ? $model->resume_speciality->name : "" ?></li>
                    <li><b>工作年限：</b><?php echo UserResumeModel::model()->work_year_arr($model->work_year) ?></li>
                    <li><b>籍　　贯：</b><?php echo $model->birthplace ? $model->birthplace->name : "" ?></li>
                    <li><b>户口所在地：</b><?php echo $model->account_where ? $model->account_where->name : "" ?></li>
                </div>
                <div class="xxpic"><img src="<?php echo $model->one_size_photo ?>" width="150" height="210" /></div>
                <div class="clear"></div>
            </ul>
            <h2>联系方式</h2>
            <ul>
                <li><b>手机：</b><?php echo $model->user ? $model->user->mobile : "" ?></li>
                <li><b>QQ：</b><?php echo $model->qq; ?></li>
                <li><b>E-mail：</b><?php echo $model->user ? $model->user->email : "" ?></li>
                <li class="w900"><b>通讯地址：</b><?php echo $model->contact_address ?></li>
                <div class="clear"></div>
            </ul>

            <h2>个人描述</h2>
            <div class="xxdes">
                <?php echo $model->description ?>
            </div>
            <h2>求职意向</h2>
            <?php $purposeModel = UserPurposeModel::model()->findAll('user_id=:user_id', array(':user_id' => Yii::app()->user->id)); ?>

            <?php foreach ($purposeModel as $k => $v): ?>
                <?php if ($v->apply_job_type_id == 1): ?>
                    <ul class="yx">   
                        <li><b>求职类型：</b><?php echo UserPurposeModel::model()->apply_job_type_arr($v->apply_job_type_id); ?></li>                    
                        <li><b>期望待遇：</b><?php echo UserPurposeModel::model()->wish_part_time_treatment_arr($v->wish_part_time_treatment_id); ?></li>
                        <li><b>期望类型：</b><?php
                            $part_time_type = explode(',', $v->part_time_type);
                            foreach ($part_time_type as $val) {
                                echo UserPurposeModel::model()->get_part_time_type($val) . "  ";
                            }
                            ?></li>
                    </ul>
                <?php else: ?>

                    <ul class="yx">            
                        <li><b>求职类型：</b><?php echo UserPurposeModel::model()->apply_job_type_arr($v->apply_job_type_id); ?></li>
                        <li><b>期望工作地点：</b><?php echo UserResumeModel::model()->get_area($v->wish_job_place_id) ?></li>
                        <li><b>期望待遇：</b><?php echo UserPurposeModel::model()->wish_treatment_arr($v->wish_treatment_id); ?></li>
                        <li><b>其他福利：</b><?php
                            $other_weal = explode(',', $v->other_weal);
                            foreach ($other_weal as $val) {
                                echo UserPurposeModel::model()->get_other_weal($val) . "  ";
                            }
                            ?></li>
                        <li><b>应聘职位：</b><?php echo UserPurposeModel::model()->get_position($v->resume_position_id) ?></li>
                        <li><b>求职状态：</b><?php echo UserPurposeModel::model()->apply_job_status_arr($v->apply_job_status); ?></li>
                        <div class="clear"></div>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>
            <h2>教育背景</h2>
            <ul class="jy">  
                <?php foreach ($educationModel as $k => $v): ?>
                    <li><span><?php echo date('Y年m月', $v->from_time) ?>-<?php echo date('Y年m月', $v->to_time) ?></span><i>|</i><span><?php echo $v->school ?></span><i>|</i><span><?php echo $v->major ?></span><br /><p><b>学习收获：</b><?php echo $v->gain ?></p></li>
                <?php endforeach; ?>
            </ul>
            <h2>培训经历
            </h2>


            <ul class="jy">
                <?php foreach ($trainModel as $k => $v): ?>
                    <li><span><?php echo date('Y年m月', $v->from_time) ?>-<?php echo date('Y年m月', $v->to_time) ?></span><i>|</i><span><?php echo $v->organization_name ?></span><i>|</i><span><?php echo $v->major ?></span><br /><p><b>学习收获：</b><?php echo $v->gain ?></p></li>
                <?php endforeach; ?>
            </ul>
            <h2>工作经历</h2>

            <ul class="jy">
                <?php foreach ($experienceModel as $k => $v): ?>
                    <li><span><?php echo date('Y年m月', $v->from_time) ?>-<?php echo date('Y年m月', $v->to_time) ?></span><i>|</i><span><?php echo $v->company_name ?></span><i>|</i><span><?php echo $v->position ?></span><br /><p><b>工作收获：</b><?php echo $v->work_highlight ?></p></li>
                <?php endforeach; ?>
            </ul>
            <h2>课外经历</h2>

            <div class="xxdes">
                <?php echo $model->extracurricular ?>
            </div>
            <div class="rc_tool">
                <button onClick="javascript:window.print();" >打印简历</button>
                <?php if (Yii::app()->user->getState('user_type') == 1) : ?><button onClick="favorite(<?php echo $model->id ?>)">加入收藏</button><?php endif; ?>
                <button onClick="window.close()">关闭本页</button>
                <?php if (Yii::app()->user->getState('user_type') == 1) : ?><button onClick="window.location.href = '<?php echo $this->createUrl('/resume') ?>'">返回列表</button><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function favorite(id) {
        var url = '<?php echo $this->createUrl('/resume/favorite') ?>';
        $.post(url, {resume_id: id}, function(data) {
            alert(data.messages);
        }, 'json');
    }
</script>
<!--主体结束-->