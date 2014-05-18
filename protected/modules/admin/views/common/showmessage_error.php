<div class="alert alert-error" >
<div>
<?php print_r($message);?>
</div>
<div >
<?php if(isset($_GET['iniframe'])):?> 
<a href="javascript:void(0);" onclick="parent.$.fancybox.close();"  class="button ddd" >关闭</a>
<?php else:?>
  <?php if($goUrl=='back'):?>
  <p> <a href="javascript:history.go(-1);"  class="button" >返回</a> </p>
  <?php elseif($goUrl=='reload'):?>
  <script>setTimeout("location.reload();",<?php echo $showTime;?>);</script>
  <?php elseif($showTime != '0' && $goUrl!=''):?>
  <?php echo $showTime/1000;?>秒后自动跳转，<a href="<?php echo $goUrl;?>" class="button">立即跳转</a> 
  <script>setTimeout("location.href='<?php echo $goUrl;?>';",<?php echo $showTime;?>);</script>
  <?php endif;?>
<?php endif;?>
</div>
</div>