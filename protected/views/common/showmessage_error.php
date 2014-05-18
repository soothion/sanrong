<style type="text/css">
    .res_content{width: 950px;padding: 5px 5px 7px; background: none repeat scroll 0% 0% rgb(245, 245, 245); position: relative;height:300px;}
    .res_content_inner{width: 885px;padding: 10px 30px;border: 1px solid rgb(226, 226, 226);background: none repeat scroll 0% 0% rgb(255, 255, 255);position: relative;height:280px;}
    .res_info{font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;margin:100px 0px 0px 300px;}
    .res_info2{margin:10px 310px;}
</style>
    <div class="wrap">
        <div class="alert alert-error res_content" >
            <div class="res_content_inner">
                <div class="res_info">
                    <?php echo $message; ?>
                </div>
                <div class="res_info2">
                    <?php if (isset($_GET['iniframe'])): ?> 
                        <a href="javascript:void(0);" onclick="parent.$.fancybox.close();"  class="button ddd" >关闭</a>
                    <?php else: ?>
                        <?php if ($goUrl == 'back'): ?>
                            <p> <a href="javascript:history.go(-1);"  class="button" >返回</a> </p>
                        <?php elseif ($goUrl == 'reload'): ?>
                            <script>setTimeout("location.reload();",<?php echo $showTime; ?>);</script>
                        <?php elseif ($showTime != '0' && $goUrl != ''): ?>
                            <?php echo $showTime / 1000; ?>秒后自动跳转，<a href="<?php echo $goUrl; ?>" class="button">立即跳转</a> 
                            <script>setTimeout("location.href='<?php echo $goUrl; ?>';",<?php echo $showTime; ?>);</script>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</div>