<p style="padding-bottom: 15px;">说明:点击备份可将所有的数据表结构和数据完全备份到项目protected/data/backup/目录下(Linux下注意将此目录权限设置为777)</p>
<table width="100%" class="table table-bordered">
    <thead>
        <tr>
            <th>备份记录</th>
            <th>文件大小</th>
            <th>备份日期</th>
            <th class="button-column"></th>
        </tr> 
    </thead>
    <tbody>
        <?php foreach ($data as $val) { ?>
            <tr height="22" >
                <td width="32%"><?php echo $val['name']; ?></td>
                <td width="17%"><?php echo $val['size']; ?></td>
                <td width="28%"><?php echo $val['time']; ?></td>
                <td width="23%">
                    <a class="delete" title="删除" rel="tooltip" href="<?php echo $this->createUrl('delete_back',array('file'=> $val['name'])) ?>"><i class="icon-trash"></i></a>
                    <a class="delete" title="下载" rel="tooltip" href="<?php echo $this->createUrl('downloadbak',array('file'=> $val['name'])) ?>"><i class="icon-download-alt"></i></a>
                    <a class="delete" title="还原" onclick="javascript:if(confirm('确定要还原吗?')){return true;}return false;" rel="tooltip" href="<?php echo $this->createUrl('recover',array('file'=> $val['name'])) ?>"><i class="icon-arrow-left"></i></a>
                    <?php
//                    echo CHtml::link('删除', array('delete_back',
//                        'file' => $val['name']
//                            ), array(
//                        "title" => "删除",
//                        'onclick' => "{if(confirm('您真的要删除吗?')){return true;}return false;}"
//                            )
//                    );
                    ?>
                    <?php //echo CHtml::link('下载', array('downloadbak', 'file' => $val['name']), array("title" => "点击下载")); ?>
                    <?php
//                    echo CHtml::link('还原', array('recover',
//                        'file' => $val['name']
//                            ), array(
//                        "title" => "还原",
//                        'onclick' => "{if(confirm('确定要还原吗?')){return true;}return false;}"
//                            )
//                    );
                    ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="4" align="center">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'backup-form',
                    'action' => $this->createUrl('mysqlback/backup'),
                    'htmlOptions' => array(
                        'style'=>'text-align:center'
                    ),
                ));
                ?>
                <?php echo CHtml::submitButton('一键备份', array('class' => 'btn submit', 'name' => 'backup')); ?>
<?php $this->endWidget(); ?> 
            </td>
        </tr>
    </tbody>
</table>
