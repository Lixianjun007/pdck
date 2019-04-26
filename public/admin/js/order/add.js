$(function () {
    $('#submit-form').validator({
        onValid: function (validity) {
            $(validity.field).closest('.sssss').find('.am-alert').hide();
        },
        onInValid: function (validity) {
            var $field = $(validity.field);
            var $group = $field.closest('.sssss');
            var $alert = $group.find('.am-alert');
            // 使用自定义的提示信息 或 插件内置的提示信息
            var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

            if (!$alert.length) {
                $alert = $('<div class="am-alert am-alert-danger"></div>').hide().appendTo($group);
            }
            $alert.html(msg).show();
        },

    });

});
$("#submit").click(function () {
    if ($("#submit-form").validator('isFormValid') === true) {
        $.ajax({
            url: "/admin/orderapi/add",
            type: "POST",
            data: $("#submit-form").serialize(),
            dataType: "json",
            context: document.body,
            success: function (data) {
                console.log(data)
                if (data.data == 1) {
                    selfalert("提醒", "<h3>下单成功！ </h3>");
                    document.getElementById("submit-form").reset();
                }
            }
        })
    }
});


