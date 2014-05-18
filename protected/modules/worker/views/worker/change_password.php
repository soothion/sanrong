<!--主体开始-->
<div class="wrap">
    <!--筛选器开始-->
    <div class="rc_s">
        <div class="rc_s_tit">
            <h1>业务记录</h1>
            <p>
                业务员编号：<?php echo Yii::app()->user->id; ?>&nbsp;&nbsp;
                <?php
                $score = 0;
                foreach ($model as $k => $v) {
                    $score = numeric($v->score) + $score;
                }
                ?>
                积分总数：￥<?php echo $score ?>&nbsp;&nbsp;
                业务员姓名：<?php echo Yii::app()->user->getState('username'); ?>&nbsp;&nbsp;
                数据更新时间：
                <?php
                $updated = 0;
                foreach ($model as $k => $v) {
                    if ($v->updated > $updated) {
                        $updated = $v->updated;
                    }
                }
                ?>
                <?php echo $updated ? date('Y-m-d H:i:s', $updated) : ""; ?>
                <a href="<?php echo $this->createUrl('/worker/index'); ?>">返回列表</a>
            </p>
        </div>
        <div class="rc_s_gm">
            <form id="id-form" action="<?php echo $this->createUrl('/worker/worker/change_password_save') ?>" method="post">
                <ul>
                    <li><em>当前密码：</em><input type="password" id="username" name="password_old" value="" /> <i>*</i></li>
                    <li><em>新 密 码：</em><input type="password" id="password" name="password" value="" /> <i>*</i></li>
                    <li><em>再次输入：</em><input type="password" id="password" name="password2" value="" />  <i>*</i></li>
                </ul>

                <div class="proBox">
                    <a href="javascript:$('#id-form').submit()" class="login_btn">提 交</a><a href="#" class="back">取消返回</a>
                    <div class="clear"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--主体结束-->