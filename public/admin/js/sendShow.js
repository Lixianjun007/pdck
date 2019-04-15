$(function () {
    $('#doc-vld-msg').validator({
        onValid: function (validity) {
            $(validity.field).closest('.am-form-group').find('.am-alert').hide();
        },

        onInValid: function (validity) {
            var $field = $(validity.field);
            var $group = $field.closest('.am-form-group');
            var $alert = $group.find('.am-alert');
            // 使用自定义的提示信息 或 插件内置的提示信息
            var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

            if (!$alert.length) {
                $alert = $('<div class="am-alert am-alert-danger"></div>').hide().appendTo($group);
            }

            $alert.html(msg).show();
        }
    });
});


$("#submit").click(function () {
    if ($('#doc-vld-msg').validator('isFormValid') === true) {
        var city = $("#doc-select-1").val();
        var date = $("#doc-ipt-pwd-1").val() + ' 00:00:00';
        var phone = $("#doc-ipt-email-10").val();
        var name = $("#doc-ipt-email-1").val();
        var number = $("#doc-ipt-email-2").val();
        console.log(city, date, phone, name, number);
        $.ajax({
            url: "submit",
            type: "POST",
            data: {
                'city': city,
                'date': date,
                'phone': phone,
                'name': name,
                'number': number
            },
            dataType: "json",
            context: document.body,
            success: function (data) {
                if (data.data == true) {
                    $("#my-alerts").modal({
                        onConfirm: function () {
                            location.replace(location.href);
                        }
                    })
                }
            }
        });

    }
});