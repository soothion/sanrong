<!--主体开始-->
<div class="main"> 
    <!--内容区开始-->
    <div class="wrap"> 
        <!--左栏 团购列表开始-->
        <div class="u_main fl">
            <?php $this->renderPartial('../common/member_header') ?>
            <table class="order_list module_table">
                <tr><th>企业名</th>
<!--                    <th>公司地址</th>-->
                </tr>
                <?php foreach($model as $v): ?>
                <tr>
                    <td><?php echo $v->company->company_name ?></td>
                    <!--<td><?php //echo $v->company->company_address ?></td>-->
                </tr>
                    <?php endforeach; ?>
                <?php foreach($virtural_enterprise_model as $v): ?>
                <tr>
                    <td><?php echo $v->name ?></td>
                    <!--<td><?php //echo $v->company->company_address ?></td>-->
                </tr>
                    <?php endforeach; ?>
                
            </table>
        </div>
        <!--左栏 团购列表结束--> 

        <!--右栏 侧边开始-->
        <?php $this->renderPartial('../common/fr') ?>
        <!--右栏 侧边结束-->
        <div class="clear"></div>
    </div>
    <!--内容区结束--> 
</div>
<!--主体结束--> 
