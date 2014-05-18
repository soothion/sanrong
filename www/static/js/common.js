// JavaScript Document
//function killerrors() { 
//	return true; 
//}
function ajaxFormSubmit(formid, callbackfunc) {
    var ajaxFormOptions = {
        data: {inajax: 1},
        dataType: 'json',
        beforeSubmit: function() {
            ajaxFormButton = $(formid + " .ajaxFormButton");
            ajaxFormButton.attr("disabled", true);
            offset = ajaxFormButton.offset();
            $("#ajaxpopdialog").remove();
            $("body").append('<div id="ajaxpopdialog" style="width:150px;  position:absolute;z-index:99999; top:100px; left:100; border:1px solid #A0A0A0;box-shadow:0 0 10px #777777;border-radius:3px 3px 3px 3px; background:none repeat scroll 0 0 #FFFFFF;padding:13px 10px; font-size:12px;"><img src="/static/images/ajax-loader.gif" />请求发送中...</div>');
            $("#ajaxpopdialog").css("top", offset.top);
            $("#ajaxpopdialog").css("left", offset.left + ajaxFormButton.width() + 30);
        },
        success: function(data) {
            if ($.type(data.info) == 'object') {
                var tmpstr = '出现以下错误';
                each_i = 1;
                info_n = 0;
                $.each(data.info, function(i, n) {
                    info_n++;
                })
                $.each(data.info, function(i, n) {
                    if (info_n > 1) {
                        tmpstr += "<br>" + each_i + "、" + n;
                        each_i++;
                    } else {
                        tmpstr = n;
                    }
                })
                data.info = tmpstr;
            }
            if (data.status == 1) {
                $("#ajaxpopdialog").html('<img src="/static/images/right.gif" width="16" /> ' + data.info);
                if (callbackfunc != undefined) {
                    eval(callbackfunc + '(data)');
                }
                setTimeout('$("#ajaxpopdialog").remove();$(".ajaxFormButton").attr("disabled",false);', 1500);
            } else {
                $("#ajaxpopdialog").html('<img src="/static/images/error_icon.gif" width="16" /> ' + data.info);
                setTimeout('$("#ajaxpopdialog").remove();$(".ajaxFormButton").attr("disabled",false);', 3000);
            }
        }
    };
    $(formid).ajaxSubmit(ajaxFormOptions);
}
function ajaxFormSubmit2(formid, callbackfunc) {
    var ajaxFormOptions = {
        data: {inajax: 1},
        dataType: 'json',
        beforeSubmit: function() {
            ajaxFormButton = $(formid + " .ajaxFormButton");
            ajaxFormButton.attr("disabled", true);
            offset = ajaxFormButton.offset();
            $("#ajaxpopdialog").remove();
            $("body").append('<div id="ajaxpopdialog" style="width:150px;  position:absolute;z-index:99999; top:100px; left:100; border:1px solid #A0A0A0;box-shadow:0 0 10px #777777;border-radius:3px 3px 3px 3px; background:none repeat scroll 0 0 #FFFFFF;padding:13px 10px; font-size:12px;"><img src="/static/images/ajax-loader.gif" />请求发送中...</div>');
            $("#ajaxpopdialog").css("top", offset.top);
            $("#ajaxpopdialog").css("left", offset.left + ajaxFormButton.width() + 30);
        },
        success: function(data) {
            if ($.type(data.info) == 'object') {
                var tmpstr = '出现以下错误';
                each_i = 1;
                info_n = 0;
                $.each(data.info, function(i, n) {
                    info_n++;
                })
                $.each(data.info, function(i, n) {
                    if (info_n > 1) {
                        tmpstr += "<br>" + each_i + "、" + n;
                        each_i++;
                    } else {
                        tmpstr = n;
                    }
                })
                data.info = tmpstr;
            }
            if (data.status == 1) {
                $("#ajaxpopdialog").html('<img src="/static/images/right.gif" width="16" /> ' + data.info);
                if (callbackfunc != undefined) {
                    eval(callbackfunc + '(data)');
                }
                setTimeout('$("#ajaxpopdialog").remove();$(".ajaxFormButton").attr("disabled",false);', 1500);
            } else {
                $("#ajaxpopdialog").html('<img src="/static/images/error_icon.gif" width="16" /> ' + data.info);
                setTimeout('$("#ajaxpopdialog").remove();$(".ajaxFormButton").attr("disabled",false); ', 3000);
            }
        }
    };
    $(formid).ajaxSubmit(ajaxFormOptions);
}

function view_verify(id, verifyurl) {
    $("#" + id).html('<img src="' + verifyurl + '?rand=' + Math.random() + '" class="verify_code_img" />看不清？<a href="javascript:view_verify(\'' + id + '\',\'' + verifyurl + '\');" >换一个</a>');
}
//window.onerror = killerrors; 
$(document).ready(function() {
    if ($.browser.msie) {
        if (parseInt($.browser.version) < 7) {
            $(window).scroll(function() {
                $(".position_fixed").css({position: "absolute"});
                $(".position_fixed").each(function(i, n) {
                    $(n).css("top", $(window).scrollTop() + parseInt($(n).attr("top")));
                })
            });

        }
    }

    $("input[type='submit']").live('click', function() {
        $(".ajaxFormButton").removeClass("ajaxFormButton");
        $(this).addClass("ajaxFormButton");
    });
    $("button[type='submit']").live('click', function() {
        $(".ajaxFormButton").removeClass("ajaxFormButton");
        $(this).addClass("ajaxFormButton");
    });

    //修改时改变输入框名称	
    $(".updateOnChange").change(
            function() {
                $(this).attr("name", $(this).attr("vname"));
            }
    );
    $(".iframelink").live('click',
            function() {
                var data = $(this).attr('href');
                if (data.split("?").length > 1) {
                    data += "&iniframe=1";
                } else {
                    data += "?iniframe=1";
                }
                var w = $(this).attr('w');
                w = w != undefined ? w : "850";
                w = w.indexOf('%') >= 0 ? w : parseInt(w);
                var h = $(this).attr('h');
                h = h != undefined ? h : "500";
                h = h.indexOf('%') >= 0 ? h : parseInt(h);
                var scrolling = $(this).attr('scrolling');
                scrolling = scrolling != undefined ? scrolling : 'auto';
                var modal = $(this).attr('modal');
                modal = modal == undefined ? false : true;
                $.fancybox({
                    'href': data,
                    'type': 'iframe',
                    'width': w,
                    'height': h,
                    "titlePosition": "inside",
                    'scrolling': scrolling,
                    'modal': modal,
                    'autoScale': false,
                    "onComplete": function() {
                        if ($("#fancybox_loader_id").length == 0) {
                            $("#fancybox-outer").append('<div id="fancybox_loader_id" style="position:absolute;z-index:9999"><img src="/static/images/ajax_loader.gif" /></div>');
                            $('#fancybox-frame').bind('load', function() {
                                $("#fancybox_loader_id").remove();
                            });
                        }
                        fancybox_loader_top = $("#fancybox-content").height() / 2 - 16;
                        fancybox_loader_left = $("#fancybox-content").width() / 2 - 16;
                        $("#fancybox_loader_id").css({top: fancybox_loader_top + 'px', left: fancybox_loader_left + 'px'});
                    }
                });

                return false;
            }
    );

    $(".btn_close_fancybox").click(function() {
        parent.$.fancybox.close();
    });
    $(".btn_parent_reload").click(function() {
        parent.location.reload();
    });
    //日期选择
//	if($(".datepicker").length>0){
//		$(".datepicker").datepicker({
//				dateFormat:'yy-mm-dd',
//				changeMonth: true,
//				changeYear: true
//		});
//	}
    if ($(".datepicker_yd").length > 0) {
        $(".datepicker_yd").datepicker({
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true
        });
    }

    if ($(".nostylexheditor").length > 0) {
        $('.nostylexheditor').xheditor({
            skin: 'nostyle',
            html5Upload: false,
            upLinkUrl: '/pm/upload/xheditor_upload_file?uniqid=' + (upload_uniqid),
            upLinkExt: 'zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
            upImgUrl: '/pm/upload/xheditor_image?uniqid=' + (upload_uniqid),
            upImgExt: 'jpg,jpeg,gif,png',
            onUpload: function(msg) {
                //$(this).after(' <input name="uploadFileId[]" type="hidden" value="'+msg[0].id+'" />');
            }
        });
    }
    if ($(".nostylexheditor_upload").length > 0) {
        $('.nostylexheditor_upload').xheditor({skin: 'nostyle', upImgUrl: '/pm/upload/xheditor_img', upImgExt: 'jpg,jpeg,gif,png'});
    }
});

function replaceAll(str, sptr, sptr1)
{
    while (str.indexOf(sptr) >= 0)
    {
        str = str.replace(sptr, sptr1);
    }
    return str;
}

function getUniqid() {
    uniqid = (Math.random() + Math.random() + Math.random()).toString();
    return "ID" + uniqid.replace(".", '');
}
function showConfirm(msg, confirmCallback, CancelCallback) {
    showConfirmSetting = {msg: '', confirmCallback: '$.fancybox.close()', CancelCallback: '$.fancybox.close()'};
    $.extend(showConfirmSetting, {msg: msg, confirmCallback: confirmCallback, CancelCallback: CancelCallback})
    $.fancybox('<div style="width:300px;text-align:center; padding:30px;" id="confirm_box">' + showConfirmSetting.msg + '<div style="padding-top:30px;"> <input type="button" value=" 确 定 " class="btn btn-primary btn-small" onclick="' + showConfirmSetting.confirmCallback + ';"/> <input type="button" value=" 取 消 " class="btn btn-small"  onclick="' + showConfirmSetting.CancelCallback + ';"/></div></div>', {overlayOpacity: 0});
}
function showMsg(msg, showTime, redirectUrl, modal) {
    if (modal == undefined) {
        modal = true;
    }
    if ($("#showMsgBox").length > 0) {
        $("#showMsgBox").html(msg);
    } else {
        $.fancybox('<div id="showMsgBox" style="width:300px;text-align:center; padding:30px;">' + msg + '</div>', {overlayOpacity: 0, modal: modal, speedIn: 0});
    }
    if (showTime == undefined) {
        showTime = 3;
    }
    if (showTime >= 0) {
        if (redirectUrl != undefined) {
            if (redirectUrl == 'reload') {
                setTimeout("location.reload(true);", showTime * 1000);
            } else {
                setTimeout("location.href='" + redirectUrl + "';", showTime * 1000);
            }
        } else {
            setTimeout("$.fancybox.close();", showTime * 1000);
        }
    }
}
function showLoading(msg) {
    msg = '<p style="background:url(/static/images/ajax_loader.gif) no-repeat;padding:10px 0 20px 45px; text-align:left;">' + msg + '</p>';
    showMsg(msg, -1);
}
function closeLoading() {
    $.fancybox.close();
}
function showSuccess(msg, showTime, redirectUrl, modal) {
    msg = '<p style="background:url(/static/images/right.gif) no-repeat;padding:10px 0 20px 40px; text-align:left;">' + msg + '</p>';
    showMsg(msg, showTime, redirectUrl, modal);
}
function showError(msg, showTime, redirectUrl, modal) {
    msg = '<p style="background:url(/static/images/error.gif) no-repeat;padding:10px 0 20px 40px; text-align:left;">' + msg + '</p>';
    showMsg(msg, showTime, redirectUrl, modal);
}
function ajaxGet(url, confirmMsg, callback) {
    setting = {url: '', confirmMsg: '', callback: '', showMsg: "操作中，请稍后...", modal: true, autoClose: true, autoCloseTime: 1.5};
    if ($.type(url) == 'string') {
        $.extend(setting, {url: url, confirmMsg: confirmMsg, callback: callback})
    } else {
        $.extend(setting, url)
    }
    if (setting.confirmMsg) {
        $.fancybox('<div style="width:300px;text-align:center; padding:30px;" id="ajax_get_msg_box">' + setting.confirmMsg + '<div style="padding-top:30px;"> <input type="button" value=" 确 定 " class="btn btn-primary btn-small" onclick="ajaxGet(\'' + setting.url + '\',\'\',\'' + setting.callback + '\');"/> <input type="button" value=" 取 消 " class="btn btn-small"  onclick="$.fancybox.close();"/></div></div>', {overlayOpacity: 0, modal: setting.modal});
    } else if (setting.url != '') {
        if ($("#ajax_get_msg_box").length == 0) {
            $.fancybox('<div style="width:300px;text-align:center; padding:30px;" id="ajax_get_msg_box"><img src="/static/images/ajax-loader.gif" />' + setting.showMsg + '</div>', {overlayOpacity: 0, modal: setting.modal});
        } else {
            $("#ajax_get_msg_box").html('<img src="/static/images/ajax-loader.gif" />' + setting.showMsg);
        }
        $.getJSON(url, {inajax: 1}, function(data) {
            if (data.status == 1) {
                $("#ajax_get_msg_box").html('<p style="background:url(/static/images/right.gif) no-repeat;padding:10px 0 20px 40px; text-align:left;">' + data.info + '</p>');
                if (setting.callback != '') {
                    eval(setting.callback + '();');
                } else {
                    setTimeout('location.reload(true);', 1000);
                }

            } else {
                $("#ajax_get_msg_box").html(data.info);
                if (setting.autoClose) {
                    setTimeout('$.fancybox.close();', setting.autoCloseTime * 1000);
                }
            }
        })
    }
}
function ajaxPost(url, data, confirmMsg, callback) {
    setting = {url: '', data: "", confirmMsg: '', callback: '', showMsg: "操作中，请稍后...", modal: true, autoClose: true, autoCloseTime: 1.5};
    //alert(data);return false;
    if ($.type(url) == 'string') {
        $.extend(setting, {url: url, data: data, confirmMsg: confirmMsg, callback: callback})
    } else {
        $.extend(setting, url)
    }
    if (setting.confirmMsg) {
        $.fancybox('<div style="width:300px;text-align:center; padding:30px;" id="ajax_post_msg_box">' + setting.confirmMsg + '<div style="padding-top:30px;"> <input type="button" value=" 确 定 " class="btn btn-primary btn-small" onclick="ajaxPost($(\'body\').data(\'ajax_post_setting\'));"/> <input type="button" value=" 取 消 " class="btn btn-small"  onclick="$.fancybox.close();"/></div></div>', {overlayOpacity: 0, modal: setting.modal});
        setting.confirmMsg = '';
        $("body").data("ajax_post_setting", setting);
    } else if (setting.url != '') {
//            alert(setting.data[0].length);return false;
//            for(var i=0;i<setting.data[0].length;i++){
//            alert(setting.data[0][i]);return false;
//        }
        if ($("#ajax_post_msg_box").length == 0) {
            $.fancybox('<div style="width:300px;text-align:center; padding:30px;" id="ajax_get_msg_box"><img src="/static/images/ajax-loader.gif" />' + setting.showMsg + '</div>', {overlayOpacity: 0, modal: setting.modal});
        } else {
            $("#ajax_post_msg_box").html('<img src="/static/images/ajax-loader.gif" />' + setting.showMsg);
        }
        if (setting.url.split("?").length > 1) {
            setting.url += '&inajax=1';
        } else {
            setting.url += '?inajax=1';
        }
//        for (var i = 0; i < setting.data.length; i++) {
//            $.each(setting.data[i], function(key, val) {
//                console.log('index in arr:' + key + ", corresponding value:" + val);
//            });
//        }
//        alert(setting.data[0][0]);
//        return false;
        $.post(setting.url, setting.data, function(data) {
            if (data.status == 1) {
                $("#ajax_post_msg_box").html('<p style="background:url(/static/images/right.gif) no-repeat;padding:10px 0 20px 40px; text-align:left;">' + data.info + '</p>');
                if (setting.callback != '') {
                    eval(setting.callback + '();');
                }
            } else {
                $("#ajax_post_msg_box").html(data.info);
                if (setting.autoClose) {
                    setTimeout('$.fancybox.close();', setting.autoCloseTime * 3000);
                }
            }
        }, 'json')
    }
}
function sys_delete_selected(data) {
    setting = {selector: "input[name='selected[]']", url: "", unselectedErrorMsg: "没有选择要删除的记录！", confirmMsg: "确定要删除吗？", callback: "", showMsg: "操作中，请稍后...", modal: true, autoClose: true, autoCloseTime: 1.5};
    $.extend(setting, data)
    //alert($(setting.selector).val());return false;
    if (setting.selector == "")
        return false;
    selected_data = $(setting.selector).serializeArray();
    //alert(selected_data.selected);return false;
    if (selected_data == "") {
        if (setting.unselectedErrorMsg != "")
            showError(setting.unselectedErrorMsg, 1);
        return false;
    }

    ajaxPost(setting.url, selected_data, setting.confirmMsg, setting.callback);
}
function reloadPage(delayTime) {
    if (delayTime == undefined) {

    } else {
        setTimeout('location.reload(true);', parseInt(delayTime) * 1000);
    }
}
function goUrl(url) {
    location.href = url;
}

jQuery.tableLineEdit = function(options) {
    var defaults = {
        updateButtonClass: 'update',
        updateUrl: ''
    };
    var opts = $.extend(defaults, options);
    $("." + opts.updateButtonClass).live('click', function() {
        $(this).closest("td").find("*").hide();
        $(this).closest("tr").find(".table-line-edit-item").each(function(i, n) {
            var _value = $(this).html();
            $(this).html('<input name="' + $(this).attr("tlname") + '" class="input-large" value="' + $(this).html() + '" />');
            $(this).append('<span style="display:none;">' + _value + '</span>');
        });
        $(this).after('<a class="table-line-edit-save" saveUrl="' + $(this).attr("href") + '" title="保存" rel="tooltip" href="javascript:void(0);"><i class="icon-ok"></i></a> <a class="table-line-edit-cancel" title="取消" rel="tooltip" href="javascript:void(0);"><i class="icon-ban-circle"></i></a>');
        return false;
    })
    $(".table-line-edit-cancel").live('click', function() {
        $(this).closest("tr").find(".table-line-edit-item").each(function(i, n) {
            $(this).html($(this).find("span").html());
        });
        $(this).closest("td").find("*").show();
        $(this).closest("td").find(".table-line-edit-save").remove();
        $(this).closest("td").find(".table-line-edit-cancel").remove();
    })
    $(".table-line-edit-cancel").live('click', function() {
        $(this).closest("tr").find(".table-line-edit-item").each(function(i, n) {
            $(this).html($(this).find("span").html());
        });
        $(this).closest("td").find("*").show();
        $(this).closest("td").find(".table-line-edit-cancel").remove();
        $(this).closest("td").find(".table-line-edit-save").remove();

    })
    $(".table-line-edit-save").live('click', function() {
        var _this = $(this);
        var data = $(this).closest("tr").find("input").serializeArray();
        showLoading("保存中...");
        $.post(opts.updateUrl + "?inajax=1&id=" + $(this).attr("saveUrl").substr(1), data, function(data) {
            if (data.status == 1) {
                _this.closest("tr").find(".table-line-edit-item").each(function(i, n) {
                    $(this).html($(this).find("input").val());
                });
                _this.closest("td").find("*").show();
                _this.closest("td").find(".table-line-edit-cancel").remove();
                _this.closest("td").find(".table-line-edit-save").remove();
                showSuccess("保存成功!", 1);
            } else {
                if ($.type(data.info) == 'object') {
                    var tmpstr = '出现以下错误';
                    each_i = 1;
                    info_n = 0;
                    $.each(data.info, function(i, n) {
                        info_n++;
                    })
                    $.each(data.info, function(i, n) {
                        if (info_n > 1) {
                            tmpstr += "<br>" + each_i + "、" + n;
                            each_i++;
                        } else {
                            tmpstr = n;
                        }
                    })
                    data.info = tmpstr;
                }
                showError(data.info, 1);
            }
        }, 'json');
    })

};
jQuery.area = function(options) {
    var defaults = {
        dataUrl: '/ajax/area',
        provinceElementId: '#id_area_province',
        cityElementId: '#id_area_city',
        areaElementId: '#id_area_area',
        provinceTip: "请选择省份",
        cityTip: "请选择城市",
        areaTip: "请选择地区",
        provinceId: '',
        cityId: '',
        areaId: ''
    };
    var opts = $.extend(defaults, options);
    $.getJSON(opts.dataUrl + '?upid=0', function(data) {
        var optionHtml = '<option value="">' + opts.provinceTip + '</option>';
        $.each(data, function(i, n) {
            optionHtml += '<option value="' + i + '">' + n + '</option>';
        });
        $(opts.provinceElementId).html(optionHtml);
        if (opts.provinceId != '' && opts.provinceId != 0) {
            $(opts.provinceElementId).val(opts.provinceId);
            $.getJSON(opts.dataUrl + '?upid=' + opts.provinceId, function(data) {
                var optionHtml2 = '<option value="">' + opts.cityTip + '</option>';
                $.each(data, function(i, n) {
                    optionHtml2 += '<option value="' + i + '">' + n + '</option>';
                });
                $(opts.cityElementId).html(optionHtml2);
                if (opts.cityId != '' && opts.cityId != 0) {
                    $(opts.cityElementId).val(opts.cityId);
                    $.getJSON(opts.dataUrl + '?upid=' + opts.cityId, function(data) {
                        var optionHtml3 = '<option value="">' + opts.areaTip + '</option>';
                        $.each(data, function(i, n) {
                            optionHtml3 += '<option value="' + i + '">' + n + '</option>';
                        });
                        $(opts.areaElementId).html(optionHtml3);
                        if (opts.areaId != '' && opts.areaId != 0) {
                            $(opts.areaElementId).val(opts.areaId);
                        }
                    });
                }
            });
        }
    });
    $(opts.provinceElementId).change(function() {
        $.getJSON(opts.dataUrl + '?upid=' + $(opts.provinceElementId).val(), function(data) {
            var optionHtml2 = '<option value="">' + opts.cityTip + '</option>';
            $.each(data, function(i, n) {
                optionHtml2 += '<option value="' + i + '">' + n + '</option>';
            });
            $(opts.cityElementId).html(optionHtml2);
            $(opts.areaElementId).html("");
        });
    });
    $(opts.cityElementId).change(function() {
        $.getJSON(opts.dataUrl + '?upid=' + $(opts.cityElementId).val(), function(data) {
            var optionHtml3 = '<option value="">' + opts.areaTip + '</option>';
            $.each(data, function(i, n) {
                optionHtml3 += '<option value="' + i + '">' + n + '</option>';
            });
            $(opts.areaElementId).html(optionHtml3);
        });
    });
};
