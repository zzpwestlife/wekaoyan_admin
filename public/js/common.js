/**
 * 将参数对象解析成
 * 符合 RequestCriteria 风格的 url
 * @param params
 * @returns {string}
 */
parserParams2Url = function (params) {

    var url = '';
    $.each(params, function (index, item) {

        if (url) {
            url += ';';
        }
        url += index + '|:' + item;

    });
    return url;

};

const MODAL_VIEW_SIZE_LARGE = 'large';
const MODAL_VIEW_SIZE_SMALL = 'small';
const MODAL_VIEW_SIZE_LOADING = 'loading';
const MODAL_VIEW_SIZE_DEFAULT = 'default';

function modalView(title, message, size, target) {
    if (target === undefined) {
        target = '#commonModal';
    }
    $(target + " .modal-title").html(title);
    $(target + " .modal-body").html(message);
    switch (size) {
        case MODAL_VIEW_SIZE_LARGE:
            modalViewToLarge(target);
            break;
        case MODAL_VIEW_SIZE_SMALL:
            modalViewToSmall(target);
            break;
        case MODAL_VIEW_SIZE_LOADING:
            modalViewToLoading(target);
            break;
        default:
            modalViewToDefault(target);
            break;
    }

}
/**
 * 弹框 切换成 大尺寸 模式
 */
function modalViewToLarge(target) {

    if (target === undefined) {
        target = '#commonModal';
    }
    $(target).removeClass("bs-example-modal-sm").addClass("bs-example-modal-lg");
    $(target + " .modal-dialog").removeClass("modal-sm").addClass("modal-lg");
    modalViewBtnConfirm("show");
    $(target + " .modal-footer").show();
}


/**
 * 弹框 切换成 小尺寸 模式
 */
function modalViewToSmall(target) {
    if (target === undefined) {
        target = '#commonModal';
    }
    $(target).removeClass("bs-example-modal-lg").addClass("bs-example-modal-sm");
    $(target + " .modal-dialog").removeClass("modal-lg").addClass("modal-sm");
    modalViewBtnConfirm("show", target);
    $(target + " .modal-footer").show();
}

/**
 * 弹框 切换成 中尺寸 模式
 */
function modalViewToDefault(target) {
    if (target === undefined) {
        target = '#commonModal';
    }
    $(target).removeClass("bs-example-modal-lg").removeClass("bs-example-modal-sm");
    $(target + " .modal-dialog").removeClass("modal-lg").removeClass("modal-sm");
    modalViewBtnConfirm("show", target);
    $(target + " .modal-footer").show();
}

/**
 * 弹框 切换成 加载中 模式
 */
function modalViewToLoading(title, target) {
    if (target === undefined) {
        target = '#commonModal';
    }

    if (title) {
        $(target + " .modal-title").html(title);
    }
    modalViewToSmall(target);
    var loadingHtml = '<div  style="clear: both;text-align: center;"><img src="/images/loaders/loader6.gif" alt="loading"></div>';
    $(target + ".modal .modal-body").html(loadingHtml);
    $(target + ".modal-footer").hide();
}

/**
 * 隐藏 确定按钮
 */
function modalViewBtnConfirm(hide, target) {
    if (target === undefined) {
        target = '#commonModal';
    }
    if ('hide' == hide) {
        $(target + " .modal-footer button.btn-confirm").hide();
    } else {
        $(target + " .modal-footer button.btn-confirm").show();
    }
}

function modalViewShow(hide, target) {
    if (target === undefined) {
        target = '#commonModal';
    }
    if ('hide' == hide) {
        $(target).modal('hide');
    } else {
        $(target).modal('show');
    }
}

function notifySuccess() {
    notify("提示", "操作成功！", {type: "success"});
}

function notifyWarning() {
    notify("提示", "操作失败，请刷新页面后重试！", {type: "warning"});
}

function notifyFailed() {
    notify("提示", "操作失败，请刷新页面后重试！", {type: "danger"});
}

// http://bootstrap-notify.remabledesigns.com/
function notify(title, message, options) {
    if (options.hasOwnProperty('modal_show') && true == options.modal_show) {
        // 暂时什么都不用做
    } else {
        $('#commonModal').modal('hide');
        $('#data_picker_modal').modal('hide');
    }
    $.notify({
            title: "<strong>" + title + ":</strong> ",
            message: message
        }, options
    );
}

(function ($) {
    /**
     * 获取url参数对象
     * @param url
     * @returns object
     */
    $.parseUrlQuery = function (url) {
        if (!url) url = window.location.search;
        var query = {}, i, params, param;
        if (url.indexOf('?') >= 0) url = url.split('?')[1];
        else return query;
        params = url.split('&');
        for (i = 0; i < params.length; i++) {
            param = params[i].split('=');
            query[param[0]] = param[1];
        }
        return query;
    };
    /**
     * 获取url参数的值
     * @param name
     * @returns {null}
     */
    $.getUrlParam = function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]);
        return null;
    }
})(jQuery);

$(function () {
    //如果没有图片则显示无图片图
    $(".thumb-image-preview img").each(function () {
        if ($(this).data('src') == '') {
            $(this).hide().parent().html('<div class="no-image"></div>');
        }
    });
});

// 清空搜索条件
$("#btn_clear").click(function () {
    $('#frm_search_info').find('select').each(function () {
        $(this).find('option:first').prop("selected", true);
        $(this).change();
    });

    $("#frm_search_info input[type=text]").each(function () {
        $(this).val("");
    });
});

/**
 * 搜索按钮
 * @param url
 */
function searchWithParams(url) {
    $("#btn_search").click(function () {
        var params = {};
        $("#frm_search_info select, #frm_search_info input[type=text], #frm_search_info input[type=hidden]").each(function () {
            var value = $(this).val();
            if ('' != value) {
                params[$(this).attr('name')] = value;
            }
        });

        if (!$.isEmptyObject(params)) {
            url += "&search=" + parserParams2Url(params);
        }

        location.href = url;
    });

}

// 判断 js 对象的类型
// https://segmentfault.com/q/1010000000464600
var class2type = {};
"Boolean Number String Function Array Date RegExp Object Error".split(" ").forEach(function (e, i) {
    class2type["[object " + e + "]"] = e.toLowerCase();
});
//当然为了兼容IE低版本，forEach需要一个polyfill，不作细谈了。
function _typeof(obj) {
    if (obj == null) {
        return String(obj);
    }
    return typeof obj === "object" || typeof obj === "function" ?
        class2type[class2type.toString.call(obj)] || "object" :
        typeof obj;
}
