$(function () {
    $('#forms').validator({
        onValid: function (validity) {
            $(validity.field).closest('.lxjerror').find('.am-alert').hide();
        },

        onInValid: function (validity) {
            var $field = $(validity.field);
            var $group = $field.closest('.lxjerror');
            var $alert = $group.find('.am-alert');
            console.log($alert);
            // 使用自定义的提示信息 或 插件内置的提示信息
            var msg = $field.data('validationMessage') || this.getValidationMessage(validity);
            if (!$alert.length) {
                $alert = $('<div class="am-alert am-alert-danger"></div>').hide().
                        appendTo($group);
            }
            $alert.html(msg).show();
        }
    });

});

function submits(start) {
    console.log($('#forms').validator('isFormValid'));


    if ($('#forms').validator('isFormValid') == true) {
        
        
        
        $.ajax({
            //几个参数需要注意一下
            type: "POST", //方法类型
            dataType: "json", //预期服务器返回的数据类型
            url: "/admin/postgoods/addgoodsAjax/start/" + start + ".html",
            data: $('#forms').serialize(),
            success: function (result) {
                if (result.code == 200) {
                    var _getname = $('#getname').val();
                    var _postname = $('#postname').val();
                    var id = $('#id').val();
                    selfalert("发货人：" + _postname, "收货人：" + _getname + "<br/>货物编号：" + result.data.number + " <br/><h3>下单成功！ </h3>");
                    if (id == null) {
                        document.getElementById("forms").reset();
                    } else {
                        window.location.href = "/admin/postgoods/addgoods/start/" + start + ".html";
                    }
                }
                ;
            },
            error: function () {
                alert("网络错误，稍后重试！");
            }
        });
    }
}