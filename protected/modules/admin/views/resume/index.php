<style type="text/css">
    a.red{color:red;margin-right:10px;}
    a.green{color:green;margin-right:10px;}
</style>
<div class="span-19">
    <div id="content">
        <p>
            <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
        </p>
        <form class="form-inline search-form" method="get" action="<?php echo $this->createUrl('index') ?>">
            <input type="text" name="id" <?php if (isset($_GET['id'])): ?>value="<?php echo $_GET['id'] ?>"<?php endif; ?> class="input-medium" placeholder="编号">
            <input type="text" name="username" <?php if (isset($_GET['username'])): ?>value="<?php echo $_GET['username'] ?>"<?php endif; ?> class="input-medium" placeholder="用户名">
            
            <select name="is_elite">        
                <option value="-1">是否精英</option>
                <option <?php if (isset($_GET['is_elite']) && $_GET['is_elite'] == 1): ?>selected="selected"<?php endif; ?> value="1">是</option>
                <option <?php if (isset($_GET['is_elite']) && $_GET['is_elite'] == 0): ?>selected="selected"<?php endif; ?> value="0">否</option>
            </select>
            <button type="submit" class="btn">搜索</button>
        </form>
        <div id="yw0" class="grid-view">
            <div class="summary"></div>
            <table class="items table table-bordered">
                <thead>
                    <tr>
                        <th width="30" id="yw0_c0">
                            <input type="checkbox" value="1" name="yw0_c0_all" id="yw0_c0_all">
                        </th>
                        <th id="yw0_c1">编号</th>
                        <th id="yw0_c2">姓名</th>
                        <th id="yw0_c3">最后更改时间</th>
                        <th width="12%">是否精英</th>
                        <th id="yw0_c4" width="30%">审核</th>
                        <th id="yw0_c5">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model as $k => $v): ?>
                        <?php
                        $resumeLogModel = ResumeLogModel::model()->find('resume_id = :id', array(':id' => $v->id));
                        if (isset($resumeLogModel)) {
                            $content = $resumeLogModel->content ? json_decode($resumeLogModel->content, TRUE) : "";
                            $account_arr = array(
                                'username', 'gender', 'marry_status', 'birthday', 'height', 'weight', 'graduate_school', 'graduate_time', 'education', 'major_first_id', 'major_second_id',
                                'grade', 'resume_speciality_id', 'eyesight', 'foreign_lang_first', 'foreign_lang_second', 'computer_level', 'work_year', 'resume_technical_titles_id',
                                'healthy', 'account_where_id', 'birthplace_id', 'one_size_photo', 'one_size_photo', 'resume_technical_titles_second_id', 'political_status'
                            );
                            $contact_arr = array(
                                'mobile', 'phone', 'qq', 'contact_address'
                            );
                            $description_arr = array('description');
                            $extracurricular_arr = array('extracurricular');

                            $purpose_arr = array(
                                'apply_job_type_id', 'wish_job_place_id', 'wish_treatment_id', 'other_weal', 'resume_position_id', 'apply_job_status',
                                'wish_part_time_treatment_id', 'part_time_type'
                            );

                            $education_arr = array(
                                'from_time', 'to_time', 'school', 'major', 'certificate', 'gain'
                            );
                            $train_arr = array(
                                'from_time', 'to_time', 'organization_name', 'major', 'certificate', 'gain'
                            );
                            $experience_arr = array(
                                'from_time', 'to_time', 'company_name', 'position', 'business_card', 'work_highlight'
                            );
                            $status_text = "";
                            if (isset($content['user_resume'][$v->id])) {
                                foreach ($account_arr as $field) {
                                    if (array_key_exists($field, $content['user_resume'][$v->id])) {
                                        if ($content['user_resume'][$v->id][$field]['status'] != 1) {
                                            $account_text = "<a href='" . $this->createUrl('/admin/resume/account', array('id' => $v->id)) . "' class='red'>基本资料</a>";
                                            break;
                                        }
                                        $account_text = "<a href='" . $this->createUrl('/admin/resume/account', array('id' => $v->id)) . "' class='green'>基本资料</a>";
                                    } else {
                                        $account_text = "<a href='" . $this->createUrl('/admin/resume/account', array('id' => $v->id)) . "' class='red'>基本资料</a>";
                                        break;
                                    }
                                }
                                foreach ($contact_arr as $field) {
                                    if (array_key_exists($field, $content['user_resume'][$v->id])) {
                                        if ($content['user_resume'][$v->id][$field]['status'] != 1) {
                                            $contact_text = "<a href='" . $this->createUrl('/admin/resume/contact', array('id' => $v->id)) . "' class='red'>联系方式</a>";
                                            break;
                                        }
                                        $contact_text = "<a href='" . $this->createUrl('/admin/resume/contact', array('id' => $v->id)) . "' class='green'>联系方式</a>";
                                    } else {
                                        $contact_text = "<a href='" . $this->createUrl('/admin/resume/contact', array('id' => $v->id)) . "' class='red'>联系方式</a>";
                                        break;
                                    }
                                }
                                foreach ($description_arr as $field) {
                                    if (array_key_exists($field, $content['user_resume'][$v->id])) {
                                        if ($content['user_resume'][$v->id][$field]['status'] != 1) {
                                            $description_text = "<a href='" . $this->createUrl('/admin/resume/description', array('id' => $v->id)) . "' class='red'>个人描述</a>";
                                            break;
                                        }
                                        $description_text = "<a href='" . $this->createUrl('/admin/resume/description', array('id' => $v->id)) . "' class='green'>个人描述</a>";
                                    } else {
                                        $description_text = "<a href='" . $this->createUrl('/admin/resume/description', array('id' => $v->id)) . "' class='red'>个人描述</a>";
                                        break;
                                    }
                                }
                                foreach ($extracurricular_arr as $field) {
                                    if (array_key_exists($field, $content['user_resume'][$v->id])) {
                                        if ($content['user_resume'][$v->id][$field]['status'] != 1) {
                                            $extracurricular_text = "<a href='" . $this->createUrl('/admin/resume/extracurricular', array('id' => $v->id)) . "' class='red'>课外经历</a>";
                                            break;
                                        }
                                        $extracurricular_text = "<a href='" . $this->createUrl('/admin/resume/extracurricular', array('id' => $v->id)) . "' class='green'>课外经历</a>";
                                    } else {
                                        $extracurricular_text = "<a href='" . $this->createUrl('/admin/resume/extracurricular', array('id' => $v->id)) . "' class='red'>课外经历</a>";
                                        break;
                                    }
                                }
                                $status_text .= $account_text . $contact_text . $description_text . $extracurricular_text;
                            } else {
                                $status_text .= "<a href='" . $this->createUrl('/admin/resume/account', array('id' => $v->id)) . "' class='red'>基本资料</a><a href='1' class='red'>联系方式</a><a href='#' class='red'>个人描述</a><a href='#' class='red'>课外经历</a>";
                            }
                            if (isset($content['user_purpose'])) {
                                foreach ($content['user_purpose'] as $value) {
                                    foreach ($purpose_arr as $field) {
                                        if (array_key_exists($field, $value)) {
                                            if ($value[$field]['status'] != 1) {
                                                $purpose_text = "<a href='" . $this->createUrl('/admin/resume/purpose', array('id' => $v->id)) . "' class='red'>求职意向</a>";
                                                break(2);
                                            }
                                            $purpose_text = "<a href='" . $this->createUrl('/admin/resume/purpose', array('id' => $v->id)) . "' class='green'>求职意向</a>";
                                        } else {
                                            $purpose_text = "<a href='" . $this->createUrl('/admin/resume/purpose', array('id' => $v->id)) . "' class='red'>求职意向</a>";
                                            break(2);
                                        }
                                    }
                                }
                            } else {
                                $purpose_text = "<a href='" . $this->createUrl('/admin/resume/purpose', array('id' => $v->id)) . "' class='red'>求职意向</a>";
                            }
                            $status_text .= $purpose_text;
                            if (isset($content['user_education'])) {
                                foreach ($content['user_education'] as $value) {
                                    foreach ($education_arr as $field) {
                                        if (array_key_exists($field, $value)) {
                                            if ($value[$field]['status'] != 1) {
                                                $education_text = "<a href='" . $this->createUrl('/admin/resume/education', array('id' => $v->id)) . "' class='red'>教育背景</a>";
                                                break(2);
                                            }
                                            $education_text = "<a href='" . $this->createUrl('/admin/resume/education', array('id' => $v->id)) . "' class='green'>教育背景</a>";
                                        } else {
                                            $education_text = "<a href='" . $this->createUrl('/admin/resume/education', array('id' => $v->id)) . "' class='red'>教育背景</a>";
                                            break(2);
                                        }
                                    }
                                }
                            } else {
                                $education_text = "<a href='" . $this->createUrl('/admin/resume/education', array('id' => $v->id)) . "' class='red'>教育背景</a>";
                            }
                            $status_text .= $education_text;
                            if (isset($content['user_train'])) {
                                foreach ($content['user_train'] as $value) {
                                    foreach ($train_arr as $field) {
                                        if (array_key_exists($field, $value)) {
                                            if ($value[$field]['status'] != 1) {
                                                $train_text = "<a href='" . $this->createUrl('/admin/resume/train', array('id' => $v->id)) . "' class='red'>培训经历</a>";
                                                break(2);
                                            }
                                            $train_text = "<a href='" . $this->createUrl('/admin/resume/train', array('id' => $v->id)) . "' class='green'>培训经历</a>";
                                        } else {
                                            $train_text = "<a href='" . $this->createUrl('/admin/resume/train', array('id' => $v->id)) . "' class='red'>培训经历</a>";
                                            break(2);
                                        }
                                    }
                                }
                            } else {
                                $train_text = "<a href='" . $this->createUrl('/admin/resume/train', array('id' => $v->id)) . "' class='red'>培训经历</a>";
                            }
                            $status_text .= $train_text;

                            if (isset($content['user_experience'])) {
                                foreach ($content['user_experience'] as $value) {
                                    foreach ($experience_arr as $field) {
                                        if (array_key_exists($field, $value)) {
                                            if ($value[$field]['status'] != 1) {
                                                $experience_text = "<a href='" . $this->createUrl('/admin/resume/experience', array('id' => $v->id)) . "' class='red'>工作经历</a>";
                                                break(2);
                                            }
                                            $experience_text = "<a href='" . $this->createUrl('/admin/resume/experience', array('id' => $v->id)) . "' class='green'>工作经历</a>";
                                        } else {
                                            $experience_text = "<a href='" . $this->createUrl('/admin/resume/experience', array('id' => $v->id)) . "' class='red'>工作经历</a>";
                                            break(2);
                                        }
                                    }
                                }
                            } else {
                                $experience_text = "<a href='" . $this->createUrl('/admin/resume/experience', array('id' => $v->id)) . "' class='red'>工作经历</a>";
                            }
                            $status_text .= $experience_text;
                        } else {
                            $status_text = "";
                        }
                        ?>
                        <tr class="odd">
                            <td class="checkbox-column">
                                <input value="<?php echo $v->id ?>" id="yw0_c0_0" type="checkbox" name="selected[]"></td>
                            <td><?php echo $v->id ?></td>
                            <td><?php echo $v->username ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $v->updated) ?></td>
                            <td>
                                <?php if (numeric($v->is_elite) == 0): ?>否&nbsp;<a href="<?php echo $this->createUrl('/admin/resume', array('id' => $v->id, 'elite' => 1)); ?>" onclick="return confirm('您确定要设为精英？')">设为精英？</a><?php endif; ?>
                                <?php if (numeric($v->is_elite) > 0): ?>是&nbsp;<a href="<?php echo $this->createUrl('/admin/resume', array('id' => $v->id, 'elite' => 0)); ?>" onclick="return confirm('您确定要取消精英？')">取消精英？</a><?php endif; ?>
                            </td>
                            <td><?php echo $status_text ?></td>
                            <td style="width:70px">
                                <a title="浏览" target="_blank" rel="tooltip" href="<?php echo $this->createUrl('/admin/resume/show',array('id'=>$v->id)); ?>"><i class="icon-eye-open"></i></a>
                                <a class="update" title="更新" rel="tooltip" href="<?php echo $this->createUrl('account', array('id' => $v->id)); ?>"><i class="icon-pencil"></i></a> 
                                <a class="delete" title="删除" rel="tooltip" href="<?php echo $this->createUrl('delete', array('id' => $v->id)); ?>"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
<!--            <div class="keys" style="display:none" title="/admin/worker.html"><span>5</span></div>-->
        </div>	</div><!-- content -->
</div>

<script>
    jQuery(document).on('click', '#yw0_c0_all', function() {
        var checked = this.checked;
        jQuery("input[name='selected\[\]']:enabled").each(function() {
            this.checked = checked;
        });
    });
    function poset_selected(url) {
        ajaxPost(url, $("input[name='selected[]']").serialize(), '', 'successfun');
    }
    function delete_selected() {
        data = {
            url: "<?php echo $this->createUrl('delete'); ?>",
            unselectedErrorMsg: "",
            confirmMsg: "确定要删除所选吗？",
            callback: "successfun"
        };
        sys_delete_selected(data);
    }
    function successfun() {
        setTimeout('location.reload();', 1000);
    }
    function deleteSuccess() {
        setTimeout('location.reload();', 1000);
    }
    jQuery(document).on('click', "input[name='selected\[\]']", function() {
        jQuery('#yw0_c0_all').prop('checked', jQuery("input[name='selected\[\]']").length == jQuery("input[name='selected\[\]']:checked").length);
    });
    jQuery(document).on('click','#yw0 a.delete',function() {
	if(!confirm('确定要删除这条数据吗?')) return false;
	var th = this,
		afterDelete = function(){};
	jQuery('#yw0').yiiGridView('update', {
		type: 'POST',
		url: jQuery(this).attr('href'),
		success: function(data) {
			jQuery('#yw0').yiiGridView('update');
			afterDelete(th, true, data);
		},
		error: function(XHR) {
			return afterDelete(th, false, XHR);
		}
	});
	return false;
});
</script>