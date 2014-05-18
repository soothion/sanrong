<style type="text/css">
    .table-line-edit-item i{cursor:pointer} 
</style>
<p> 
    <a href="javascript:void();" onclick="delete_selected();" class="btn btn-primary btn-small">删除</a> 
    <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-small">添加顶级分类</a> 
</p>
<div id="yw0">
    <form action="<?php echo $this->createUrl('update_sort'); ?>" method="post">
    <table class="table">
        <tr>
            <th width="5%"><input type="checkbox" value="1" name="yw0_c0_all" id="yw0_c0_all" /></th>
            <th width="70%">分类名称</th>
            <th width="10%">操作</th>
        </tr>
        <?php foreach ($model as $key => $value): ?>
            <tr>
                <td><input value="<?php echo $value['id'] ?>" type="checkbox" name="selected[]" />&nbsp<?php echo $value['id'] ?></td>
                <td class="table-line-edit-item" chil_show ="1" pid="<?php echo $value['pid']; ?>" cid="<?php echo $value['id']; ?>">
                    <?php echo $value['html'] ?><i class="icon-zoom-out"></i><a href="<?php echo $this->createUrl('article/list',array('cate_id'=>$value['id'])); ?>"><?php echo $value['name']; ?></a>
                </td>
                <td>
                    <a class="update" href="<?php echo $this->createUrl('update', array('id' => $value['id'])) ?>"><i class="icon-pencil"></i></a>
                    <a  href="<?php echo $this->createUrl('create', array('pid' => $value['id'])) ?>"><i class="icon-plus"></i></a>
                    <a class="delete" cid="<?php echo $value['id'] ?>" href="<?php echo $this->createUrl('delete', array('id' => $value['id'])) ?>"><i class="icon-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </form>
</div>
<div class="clearfix"></div>
<script>
    jQuery(document).on('click','#yw0_c0_all',function() {
        var checked=this.checked;
        jQuery("input[name='selected\[\]']:enabled").each(function() {this.checked=checked;});
    });
    jQuery(document).on('click','#yw0 a.delete',function() {
        if(!confirm('确定要删除这条数据吗?')) return false;
        if(find_all_chilren($(this).attr('cid')).length>0) {
            alert('先删除子栏目！');return false;
        }
    });
    function poset_selected(url){
        ajaxPost(url,$("input[name='selected[]']").serialize(),'','successfun');
    }
    function delete_selected(){ 
        data = {
            url:"<?php echo $this->createUrl('delete'); ?>",
            unselectedErrorMsg:"",
            confirmMsg:"确定要删除所选吗？",
            callback:"successfun"
        };
        sys_delete_selected(data);
    }
    function successfun(){
        setTimeout('location.reload();',1000);
    }
    function deleteSuccess(){
        setTimeout('location.reload();',1000);
    }
    var cids = new Array();
    function find_all_chilren(id){
        $.each($('.table-line-edit-item'),function(k,v){ 
            if($(this).attr('pid') == id ){
                cids[k] = $(this).attr('cid');
                find_all_chilren($(this).attr('cid'));
            }
        });
        $.each(cids,function(k,v){
            if(v == undefined){
                cids.splice(k,1);
            }
        })
        return cids;
    }
    $(function(){
        $(".table-line-edit-item i").click(function(){
            var this_td = $(this).parent('td');
            var cidss = find_all_chilren(this_td.attr('cid'));
            if( this_td.attr('chil_show') == 0 ){
                this_td.find('i').removeClass().addClass('icon-zoom-out');
                this_td.attr('chil_show',1);
                $.each(cidss,function(k,v){
                    $(".table-line-edit-item[cid='"+v+"']").attr('chil_show',1)
                    $(".table-line-edit-item[cid='"+v+"']").parent('tr').show();
                })
            }else{
                this_td.find('i').removeClass().addClass('icon-zoom-in');
                this_td.attr('chil_show',0);
                $.each(cidss,function(k,v){
                    $(".table-line-edit-item[cid='"+v+"']").attr('chil_show',0)
                    $(".table-line-edit-item[cid='"+v+"']").parent('tr').hide();
                })
            }
            cids = new Array();
        });
    })
    jQuery(document).on('click', "input[name='selected\[\]']", function() {
        jQuery('#yw0_c0_all').prop('checked', jQuery("input[name='selected\[\]']").length==jQuery("input[name='selected\[\]']:checked").length);
    });
</script>