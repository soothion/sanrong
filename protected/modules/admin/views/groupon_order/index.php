<div class="span-19">
    <div id="content">
        <p>
            <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a>
        </p>
        <form class="form-inline search-form" method="get" action="<?php echo $this->createUrl('index') ?>">
            <input type="text" name="order_sn" <?php if (isset($_GET['order_sn'])): ?>value="<?php echo $_GET['order_sn'] ?>"<?php endif; ?> class="input-medium" placeholder="订单号">
            <select name="order_type">
                <option value="0">请选择支付类型</option>
                <?php foreach (OrdersModel::model()->get_order_type() as $k => $v): ?>
                    <?php if (numeric($k) > 0): ?>
                <option <?php if (isset($_GET['order_type']) && $_GET['order_type'] == $k): ?>selected="selected"<?php endif; ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
            </select>
            <select name="order_status">
                <option value="-1">请选择订单状态</option>
                <?php foreach (OrdersModel::model()->get_order_status() as $k => $v): ?>

                <option <?php if (isset($_GET['order_status']) && $_GET['order_status'] == $k): ?>selected="selected"<?php endif; ?> value="<?php echo $k ?>"><?php echo $v ?></option>

                    <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">搜索</button>
        </form>
        <div id="yw0" class="grid-view">
            <div class="summary"></div>
            <table class="items table table-bordered">
                <thead>
                    <tr>
                        <th width="30" id="yw0_c0">
                            <input type="checkbox" value="0" name="yw0_c0_all" id="yw0_c0_all">
                        </th>
                        <th id="yw0_c1">编号</th>
                        <th id="yw0_c2">订单号</th>
                        <th id="yw0_c3">支付类型</th>
                        <th width="12%">支付状态</th>
                        <th id="yw0_c4" width="30%">操作时间</th>
                        <th id="yw0_c5">操作</th>
                    </tr>
                </thead>
                <tbody>   
                    <?php foreach ($model as $v): ?>
                        <tr class="odd">
                            <td class="checkbox-column">
                                <input value="<?php echo $v->id ?>" id="yw0_c0_0" type="checkbox" name="selected[]"></td>
                            <td><?php echo $v->id ?></td>
                            <td><?php echo $v->order_sn ?></td>
                            <td><?php echo OrdersModel::model()->get_order_type($v->order_type) ?></td>
                            <td>
                                <?php if ($v->order_type == 4 && $v->order_status == 0): ?>
                                    <?php echo OrdersModel::model()->get_order_status($v->order_status) ?>&nbsp;<a onclick="return confirm('确定该用户付完款？')" href="<?php echo $this->createUrl('/admin/groupon_order/order_status', array('id' => $v->id, 'order_status' => 1)) ?>">已付款？</a>
                                <?php elseif ($v->order_type == 4 && $v->order_status == 1): ?>
                                    <?php echo OrdersModel::model()->get_order_status($v->order_status) ?>&nbsp;<a onclick="return confirm('确定该用户未付款？')" href="<?php echo $this->createUrl('/admin/groupon_order/order_status', array('id' => $v->id, 'order_status' => 0)) ?>">未付款？</a>
                                <?php else: ?>
                                    <?php echo OrdersModel::model()->get_order_status($v->order_status) ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s', $v->status_time) ?></td>
                            <td style="width:70px">
                                <a title="订单详情" rel="tooltip" href="<?php echo $this->createUrl('/admin/groupon_order/view', array('id' => $v->id)) ?>"><i class="icon-eye-open"></i></a>
    <!--                                <a class="update" title="更新" rel="tooltip" href="<?php //echo $this->createUrl('account', array('id' => $v->id));     ?>"><i class="icon-pencil"></i></a> 
                                <a class="delete" title="删除" rel="tooltip" href="<?php //echo $this->createUrl('delete', array('id' => $v->id));     ?>"><i class="icon-trash"></i></a>-->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                $this->widget('CLinkPager', array(
                    'header' => '',
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '末页',
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'pages' => $pager,
                    'maxButtonCount' => 13,
                    'htmlOptions' => array('class' => 'pagination'),
                        )
                );
                ?>
            </div>
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
</script>

