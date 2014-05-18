<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
        if (file_exists(Yii::app()->basePath . '/config/setting.php')) {
            $setting = include Yii::app()->basePath . '/config/setting.php';
        } else {
            $setting = array(
                'title' => '三容人力',
                'keyword' => '三容人力',
                'description' => '三容人力                                                                                                                                ',
                'filter_text' => '',
            );
        }
        ?>
        <meta name="Keywords" content="<?php echo $setting['keyword'] ?>" />
        <meta name="Description" content="<?php echo $setting['description'] ?>" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/global.css" rel="stylesheet" media="all" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/index.css" rel="stylesheet" media="all" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/kefu.css" rel="stylesheet" media="all" />
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/jquery/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.1.js"></script>
        <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.js"></script>
        <title><?php echo Yii::app()->name ?> - <?php echo isset($this->seo['title']) ? $this->seo['title'] : ""; ?></title>
    </head>

    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/static/jquery/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/static/js/common.js"></script>
    <body>
        <!--头部开始-->
        <div class="top">
            <div class="top_nav">                
                <?php if (isset(Yii::app()->user->id) && Yii::app()->user->id > 0): ?>
                    您好：<?php echo Yii::app()->user->name ?>
                    <?php if (isset($this->module) && $this->module->name == 'worker'): ?>
                        <a href='<?php echo $this->createUrl('/worker/login/logout') ?>' class="icon_t2">注销</a>
                    <?php else: ?>
                        <a href='<?php echo $this->createUrl('/member/login/logout') ?>' class="icon_t2">注销</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo $this->createUrl('/member/register') ?>" class="icon_t1">注册</a>
                    <a href="<?php echo $this->createUrl('/member/login') ?>" class="icon_t2">登陆</a>
                <?php endif; ?>
                <a href="<?php echo $this->createUrl('/member') ?>" class="icon_t3">人才在线系统</a>
                <a href="<?php echo $this->createUrl('/worker') ?>" class="icon_t4">业务管理系统</a> 
                <a href="<?php echo $this->createUrl('/member/register_enterprise') ?>" class="icon_t4">企业申请</a> 
            </div>
            <div class="top_con">
                <div class="top_l"> <a href="#" class="logo"></a> </div>
                <div class="top_r">
                    <form action="<?php echo $this->createUrl('/groupon_category/index') ?>">
                        <input name="key" type="text" class="key" />
                        <input type="hidden" name="filter" value="0-0-0-0-idesc" />
                        <input type="submit" class="btn" value="" />
                    </form>
                </div>
            </div>
        </div>
        <!--头部结束--> 

        <!--导航菜单开始-->
        <div class="menu">
            <div class="menu_con">
                <div class="menu_list">
                    <a href="<?php echo $this->createAbsoluteUrl('/') ?>" <?php if (!isset($this->module) && $this->id == 'index'): ?>class='on'<?php endif; ?>>首 页</a><span></span>
                    <a href="<?php echo $this->createUrl('/onefour') ?>" <?php if (!isset($this->module) && $this->id == 'onefour'): ?>class='on'<?php endif; ?>>培训中心</a><span></span>
                    <a href="<?php echo $this->createUrl('/resume'); ?>" <?php if (!isset($this->module) && $this->id == 'resume'): ?>class='on'<?php endif; ?>>人才在线</a><span></span>
                    <a href="<?php echo $this->createUrl('/member') ?>" <?php if (isset($this->module) && $this->module->name == 'member'): ?>class='on'<?php endif; ?>>个人中心</a><span></span>
                    <?php if (isset($this->module) && $this->module->name == 'worker'): ?>
                        <a href="<?php echo $this->createUrl('/worker') ?>" <?php if (isset($this->module) && $this->module->name == 'worker'): ?>class='on'<?php endif; ?>>业务系统</a><span></span>
                    <?php endif; ?>
                </div>
                <div class="menu_r"><a href="#" class="down">下载三容手机版</a></div>
            </div>
        </div>


        <?php echo $content; ?>

        <?php
        $singlepage = SinglepageModel::model()->findAll();
        $news_cate = NewsCategoryModel::model()->findAll();
        ?>
        <!--页脚开始-->
        <div class="footer">
            <div class="con">
                <div class="foot_item">
                    <a href="<?php echo $this->createurl('/onefour') ?>" >培训中心</a> | 
                    <a href="<?php echo $this->createurl('/member') ?>" >人才在线</a> | 
                    <a href="<?php echo $this->createurl('/worker') ?>" >业务系统</a> |                    

                    <?php foreach ($news_cate as $k => $v): ?>
                        <a href="<?php echo $this->createUrl('/news/list', array('cate_id' => $v->id)) ?>"><?php echo $v->name ?></a> | 
                    <?php endforeach; ?>

                    <?php foreach ($singlepage as $k => $v): ?>
                        <a href="<?php echo $this->createUrl('/singlepage/view', array('id' => $v->id)) ?>"><?php echo $v->title ?></a><?php if (count($singlepage) - 1 != $k): ?> | <?php endif; ?>
                    <?php endforeach; ?>

                    <div class="clear"></div>
                </div>
                <div class="f_logo"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/logo.gif" width="185" height="61" /></a></div>
                <div class="f_copyright">
                    Copyright &copy; 2010-2013 三容人力. All rights reserved.　ICP备案证书号:琼 ICP备000000号<br />
                    海口市三容教育咨询有限公司版权所有，并保留所有权利。<br />
                    咨询热线：400--111-8888<br />
                </div>
                <div class="f_link"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/f_link1.gif" width="123" height="40" /></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/f_link2.gif" width="103" height="40" /></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/f_link3.gif" width="110" height="40" /></a></div>
            </div>
        </div>
        <!--页脚结束-->
        <!--客服代码-->
        <DIV id=floatTools class=float0831>
            <DIV class=floatL>
                <A id=aFloatTools_Show class=btnOpen 
                   title=查看在线客服 
                   onclick="javascript:$('#divFloatToolsView').animate({width: 'show', opacity: 'show'}, 'normal', function() {
                               $('#divFloatToolsView').show();
                           });
                           $('#aFloatTools_Show').attr('style', 'display:none');
                           $('#aFloatTools_Hide').attr('style', 'display:block');" 
                   href="javascript:void(0);">展开</A> 

                <A style="DISPLAY: none" id=aFloatTools_Hide class=btnCtn 
                   title=关闭在线客服 
                   onclick="javascript:$('#divFloatToolsView').animate({width: 'hide', opacity: 'hide'}, 'normal', function() {
                               $('#divFloatToolsView').hide();
                           });
                           $('#aFloatTools_Show').attr('style', 'display:block');
                           $('#aFloatTools_Hide').attr('style', 'display:none');" 
                   href="javascript:void(0);">收缩</A> </DIV>
            <DIV id=divFloatToolsView class=floatR style="DISPLAY: none">
                <DIV class=tp></DIV>
                <DIV class=cn>
                    <UL>
                        <LI class=top>
                            <H3 class=titZx>QQ咨询</H3>
                        </LI>
                        <LI><SPAN class=icoZx>在线咨询</SPAN> </LI>
                        <LI><A class=icoTc href="#">A老师</A> </LI>
                        <LI><A class=icoTc href="javascript:void(0);">B老师</A> </LI>
                        <LI><A class=icoTc href="#">C老师</A> </LI>
                        <LI class=bot><A class=icoTc href="javascript:void(0);">D老师</A> </LI>
                    </UL>
                    <UL class=webZx>
                        <LI class=webZx-in><A href="#" target="_blank" style="FLOAT: left"><IMG src="/static/images/right_float_web.png" border="0px"></A> </LI>
                    </UL>
                    <UL>
                        <LI>
                            <H3 class=titDh>电话咨询</H3>
                        </LI>
                        <LI><SPAN class=icoTl>400-000-0000</SPAN> </LI>

                    </UL>
                </DIV>
            </DIV>
        </DIV>
        <!--客服代码结束-->
    </body>
</html>
