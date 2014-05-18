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
                    foreach($model as $k=>$v){
                          $score = numeric($v->score) + $score;  
                    }
                ?>
                    
                积分总数：￥<?php echo $score; ?>&nbsp;&nbsp;
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
                <a href="<?php echo $this->createUrl('/worker/worker/change_password'); ?>">修改密码</a>
            </p>
        </div>
        <div class="rc_s_con">
            <?php if (count($model)): ?>
                <!--不需要分页，记录直接罗列出来，最新发布的在最上面。状态主要是针对“申诉”来讲的，分为：正常（发布后及正常）；申诉中，等待回复；申诉中，<a href="#">已回复</a>；<a href="#">申诉失败</a>；申诉成功。 看完后删除本说明。-->
                <table class="order_list yw_jl">
                    <tr>
                        <th style="width:10%;">编号</th>
                        <th style="width:15%;">时间</th>
                        <th style="width:45%;">内容</th>
                        <th style="width:10%;">积分</th>
                        <th style="width:10%;">状态</th>
                        <th style="width:10%;">操作</th>
                    </tr>
                    <?php foreach($model as $k=>$v): ?>
                    <tr>
                        <td><?php echo Yii::app()->user->id; ?></td>
                        <td><?php echo date('Y-m-d H:i:s',$v->created); ?></td>
                        <td><?php echo $v->content; ?></td>
                        <td>￥<?php echo $v->score ?>  </td>
                        <td><?php echo WorkerInfoModel::model()->getStatus($v->status) ?></td>
                        <td><a href="<?php echo $this->createUrl('/worker/appeal',array('worker_info_id'=>$v->id)) ?>">申诉</a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <div class="rc_tool">
                    <button onClick="javascript:window.print();" >打印记录</button>
                    <button onClick="window.close()">关闭本页</button>
                    <button onClick="window.location.href = '/'">返回首页</button>
                </div>
            <?php else: ?>
                暂无数据
            <?php endif; ?>
        </div>
    </div>
</div>
<!--主体结束-->