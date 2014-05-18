<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
        <!--左栏 团购列表开始-->
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>

            <table class="order_list module_table">
                <tr>
                    <th style="width:18%;">照片</th>
                    <th style="width:20%;">姓名</th>
                    <th style="width:10%;">年龄</th>
                    <th style="width:17%;">学历</th>
                    <th style="width:15%;">类型</th>
                    <th style="width:20%;">操作</th>
                </tr>
                <?php foreach($model as $k=>$v): ?>
                <tr>
                    <td style="text-align:center;"><a href="#" target="_blank"><img src="<?php echo $v->resume->one_size_photo ?>" width="75" height="105" alt="title"/></a></td>
                    <td> <a href="#" target="_blank"><?php echo $v->resume->username ?></a></td>
                    <td> <?php echo $v->resume->age ?> </td>
                    <td><?php echo UserResumeModel::model()->education_arr($v->resume->education); ?> </td>
                    <td><?php echo UserResumeModel::model()->apply_job_type_arr($v->resume->apply_job_type); ?></td>
                    <td><span class="details_link"> <a href="<?php echo $this->createUrl('/resume/show',array('id'=>$v->resume_id)) ?>" target="_blank">查看简历</a></span>
                        <a href="#" class="print_upload d_block">打印简历</a>
                        <a href="javascript:cancelFavorite(<?php echo $v->user_id.','.$v->resume_id ?>)" class="delete_order d_block">取消收藏</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <!--左栏 团购列表结束--> 

        <!--右栏 侧边开始-->
        <?php echo $this->renderPartial('../common/fr') ?>
        <!--右栏 侧边结束-->
        <div class="clear"></div>
    </div>
    <!--内容区结束--> 
</div>
<!--主体结束-->
<script type="text/javascript">
    function cancelFavorite(user_id,resume_id){
        var url = '<?php echo $this->createUrl('/member/resume/cancel_favorite') ?>';
        $.post(url,{user_id:user_id,resume_id:resume_id},function(data){
            if(data.status == 1){
                alert(data.messages);
                window.location.href = '<?php echo $this->createUrl("/member/resume/favorite") ?>';
            }else{
                alert(data.messages);
            }
        },'json');
    }
</script>