<script type="text/javascript" src="/static/jquery/jquery.js"></script>
<!--主体开始-->
<div class="main">
    <div class="wrap">
        <!--筛选器开始-->
        <div class="rc_c">
            <div class="rc_show_nav">
                <div class="con">
                    <?php if (!isset($search_param['apply_job_type']) && !isset($search_param['is_elite'])): ?>
                        <a href="javascript:;" class="on">简历搜索</a>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('/resume') ?>" >简历搜索</a>
                    <?php endif; ?>

                    <?php if (isset($search_param['apply_job_type']) && $search_param['apply_job_type'] == 1): ?>
                        <a href="javascript:;" class="on">兼职人才</a>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('/resume/index', array('apply_job_type' => 1)) ?>">兼职人才</a>
                    <?php endif; ?>

                    <?php if (isset($search_param['apply_job_type']) && $search_param['apply_job_type'] == 3): ?>
                        <a href="javascript:;" class="on">实习人才</a>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('/resume/index', array('apply_job_type' => 3)) ?>">实习人才</a>
                    <?php endif; ?>

                    <?php if (isset($search_param['apply_job_type']) && $search_param['apply_job_type'] == 2): ?>
                        <a href="javascript:;" class="on">全职人才</a>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('/resume/index', array('apply_job_type' => 2)) ?>">全职人才</a>
                    <?php endif; ?>

                    <?php if (isset($search_param['is_elite']) && $search_param['is_elite'] == 1): ?>
                        <a href="javascript:;" class="on">精英人才</a>
                    <?php else: ?>
                        <a href="<?php echo $this->createUrl('/resume/index', array('is_elite' => 1)) ?>">精英人才</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="rc_search_con">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => '',
                    'action' => $this->createUrl(''),
                    'method' => 'get',
                    'htmlOptions' => array(
                    ),
                ));
                ?>
                <ul>
                    <li>
                        <span>技术职称</span>
                        <?php echo $form->dropDownList($model, 'technical_titles', UserResumeModel::model()->get_technical_titles(), array('prompt' => '请选择', 'name' => 'technical_titles')); ?>
                    </li>

                    <li>
                        <span>专业</span>
                        <?php echo $form->dropDownList($model, 'major', UserResumeModel::model()->get_major(), array('prompt' => '请选择', 'name' => 'major')); ?>
                    </li>
                    <li>
                        <span>学历</span>
                        <?php echo $form->dropDownList($model, 'education', UserResumeModel::model()->education_arr(), array('prompt' => '请选择', 'name' => 'education')); ?>
                    </li>
                    <li>
                        <span>年级</span>
                        <?php echo $form->dropDownList($model, 'grade', UserResumeModel::model()->get_grade_arr(), array('prompt' => '请选择', 'name' => 'grade')); ?>
                    </li>
                    <div class="clear"></div>
                </ul>
                <ul>
                    <li>
                        <span>技能特长</span>
                        <?php echo $form->dropDownList($model, 'resume_speciality_id', UserResumeModel::model()->get_speciality(), array('prompt' => '请选择', 'name' => 'resume_speciality_id')); ?>
                    </li>

                    <li>
                        <span>工作经验</span>
                        <?php echo $form->dropDownList($model, 'work_year', UserResumeModel::model()->work_year_arr(), array('prompt' => '请选择', 'name' => 'work_year')); ?>
                    </li>
                    <?php if (!isset($search_param['apply_job_type']) || $search_param['apply_job_type'] != 1): ?>
                        <li>
                            <span>期望薪资</span>
                            <?php echo $form->dropDownList($model, 'wish_treatment_id', UserPurposeModel::model()->wish_treatment_arr(), array('prompt' => '请选择', 'name' => 'wish_treatment_id')); ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!isset($search_param['apply_job_type']) || $search_param['apply_job_type'] != 1): ?>
                        <li>
                            <span>工作地点</span>
                            <?php echo $form->dropDownList($model, 'wish_job_place_id', UserPurposeModel::model()->get_area(), array('prompt' => '请选择', 'name' => 'wish_job_place_id')); ?>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($search_param['apply_job_type']) && $search_param['apply_job_type'] == 1): ?>
                        <li>
                            <span>期望薪资</span>
                            <?php echo $form->dropDownList($model, 'wish_part_time_treatment_id', UserPurposeModel::model()->wish_part_time_treatment_arr(), array('prompt' => '请选择', 'name' => 'wish_part_time_treatment_id')); ?>
                        </li>
                    <?php endif; ?> 
                    <div class="clear"></div>
                </ul>
                <ul>
                    <?php if (!isset($search_param['apply_job_type']) || $search_param['apply_job_type'] != 1): ?>
                        <li>
                            <span>期望职位</span>
                            <?php echo $form->dropDownList($model, 'resume_position_id', UserPurposeModel::model()->get_position(), array('prompt' => '请选择', 'name' => 'resume_position_id')); ?>
                        </li>
                    <?php endif; ?>
                    <li>
                        <span>性别</span>
                        <?php echo $form->dropDownList($model, 'gender', UserResumeModel::model()->gender_arr(), array('prompt' => '请选择', 'name' => 'gender')); ?>
                    </li>

                    <li>
                        <span>年龄</span>
                        <?php echo $form->dropDownList($model, 'age', UserResumeModel::model()->age_arr(), array('prompt' => '请选择', 'name' => 'age')); ?>
                    </li>
                    <li>
                        <span>籍贯</span>
                        <?php echo $form->dropDownList($model, 'birthplace_id', UserResumeModel::model()->get_area(), array('prompt' => '请选择', 'name' => 'birthplace_id')); ?>
                    </li>
                    <div class="clear"></div>
                </ul>
                <div class="input_key"><span>关键字</span><?php echo $form->textField($model, 'description', array('name' => 'description', 'id' => 'search_keyword')); ?><input  type="button" id="searchDesc"  class="rc_btn" value="搜索简历" /></div>
                <?php $this->endWidget(); ?>
            </div>
            <!--筛选器结束-->
            <div class="rc_list">
                <!--默认这个div是隐藏的，有已选条件的时候，这个div才在这里出现。style="display:none;"-->
                <div class="searchdel">
                    <div class="tit">您本次搜索的范围：</div>
                    <div class="con">
                        <?php $attr = UserResumeModel::model()->attributeLabels(); ?>

                        <?php foreach ($search_param as $k => $v): ?>
                            <?php if ($k != 'apply_job_type' && $k != 'page' && $k != 'is_elite'): ?>
                                <?php if ($k == 'description'): ?>
                                    <a href="javascript:removeSearch('<?php echo $k; ?>')" title="删除该选择"><?php echo '关键字：' . $v; ?></a>
                                <?php else: ?>
                                    <a href="javascript:removeSearch('<?php echo $k; ?>')" title="删除该选择"><?php echo $attr[$k] . ":" . UserResumeModel::model()->get_search_text($k, $v); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="rc_list_show">
                    <ul>
                        <li class="tit">
                            <span class="t1"><strong>编号</strong></span>
                            <span class="t2"><strong>性别</strong></span>
                            <span class="t3"><strong>年龄</strong></span>
                            <span class="t4"><strong>学历</strong></span>
<!--                            <span class="t5"><strong>应聘职位</strong></span>-->
                            <span class="t6"><strong>专业</strong></span>
                            <span class="t7"><strong>毕业院校</strong></span>
                            <span class="t8"><strong>工作经验</strong></span>
<!--                            <span class="t9"><strong>期望待遇</strong></span>-->
                            <span class="t10"><strong>更新时间</strong></span>
                        </li>
                        <?php foreach ($resumeListModel as $k => $v): ?>
                            <li>
                                <span class="t0"><?php echo $k + 1 ?></span>
                                <span class="t1"><a href="<?php echo $this->createUrl('/resume/show', array('id' => $v->id)) ?>" target="_blank"><?php echo get_resume_id($v->id) ?></a><?php if (!empty($v->one_size_photo)): ?><em></em><?php endif; ?>
                                </span>
                                <span class="t2"><?php echo UserResumeModel::model()->gender_arr($v->gender) ?></span>
                                <span class="t3"><?php echo $v->age ?></span>
                                <span class="t4"><?php echo UserResumeModel::model()->education_arr($v->education) ?></span>
    <!--                                <span class="t5"><?php //echo $v->resume_position->name  ?></span>-->
                                <span class="t6"><?php echo $v->major_first ? $v->major_first->name : "" ?></span>
                                <span class="t7"><?php echo $v->graduate_school ?>  </span>
                                <span class="t8"><?php echo UserResumeModel::model()->work_year_arr($v->work_year) ?></span>
    <!--                                <span class="t9"><?php //echo UserResumeModel::model()->wish_treatment_arr($v->wish_treatment)  ?></span>-->
                                <span class="t10"><?php echo date('Y-m-d', $v->created) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="rc_page">
                        <!--<span class="page_cur">1</span><a href="#">2</a> <a href="#">下一页</a> <a  href="#">最后一页</a> 20 条记录-->
                        <?php
                        $this->widget('CLinkPager', array(
                            'header' => '',
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '末页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'pages' => $pages,
                            'maxButtonCount' => 13
                                )
                        );
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <!--内容区开始-->
        <!--内容区结束--> 
    </div>
</div>
<!--主体结束--> 
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search_resume',
    'action' => $this->createUrl(''),
    'method' => 'get',
    'htmlOptions' => array(
    ),
        ));
?>
<?php if (isset($search_param)): ?>
    <?php foreach ($search_param as $k => $v): ?>
        <input type="hidden" name='<?php echo $k ?>' value='<?php echo $v ?>' />
    <?php endforeach; ?>
<?php endif; ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function() {
        $('.rc_search_con select').change(function() {
            var name = $(this).attr('name');
            var val = $(this).val();
            if (!val) {
                $("#search_resume input[name=" + name + "]").remove();
            } else {
                if ($("#search_resume input[name=" + name + "]").length > 0) {
                    $("#search_resume input[name=" + name + "]").val(val);
                } else {
                    var _html = "<input type='hidden' name='" + name + "' value='" + val + "' /> ";
                    $('#search_resume').append(_html);
                }
            }
            $('#search_resume').submit();
        });

        $('#searchDesc').click(function() {
            var name = 'description';
            var val = $('#search_keyword').val();
            if (!val) {
                $("#search_resume input[name=" + name + "]").remove();
            } else {
                if ($("#search_resume input[name=" + name + "]").length > 0) {
                    $("#search_resume input[name=" + name + "]").val(val);
                } else {
                    var _html = "<input type='hidden' name='" + name + "' value='" + val + "' /> ";
                    $('#search_resume').append(_html);
                }
            }
            $('#search_resume').submit();
        });
    });
    function removeSearch(name) {
        $("#search_resume input[name=" + name + "]").remove();
        $('#search_resume').submit();
    }
</script>