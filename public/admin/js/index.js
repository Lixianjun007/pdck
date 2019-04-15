/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function urlto(start) {
    window.location.href = "/admin/postgoods/addgoods/start/" + start + ".html";
}

function delgoods(id) {
    var id = id;
}

//alert封装函数
function selfalert(title = 'test', content = 'test') {
    $('.am-modal-hd').html(title);  //标题
    $('.am-modal-bd').html(content);  //内容
    $('#alert').trigger('click');
}

//处理订单
$('.operategoods').click(function () {
    var id = $(this).val();
    var start = $(this).attr('start');
    window.location.href = "/admin/postgoods/addgoods/start/" + start + "/id/" + id + ".html";

});


//删除条目
$('.delgoods').click(function () {
    var id = $(this).val();
    $('#confirmInfo').html('确定要删除这条记录吗？');

    $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function () {
            $.ajax({
                //几个参数需要注意一下
                type: "POST", //方法类型
                dataType: "json", //预期服务器返回的数据类型
                url: "/admin/index/del.html",
                data: {"id": id},
                success: function (result) {
                    if (result.code == 200) {
                        window.location.reload();
                    }
                    if (result.code == 0) {
                        alert(result.data);
                        window.location.reload();
                    }
                    ;
                },
                error: function () {
                    alert("网络错误，稍后重试！");
                }
            });
        },
        onCancel: function () {

        },
    });

});
//全选/全不选
$(".chooseall").click(function () {

    if (this.checked) {

        $("[name=items]:checkbox").prop('checked', true)
    } else {

        $("[name=items]:checkbox").prop('checked', false)
    }
});

//装车
$("#savetocar").click(function () {
    var ids = new Array();
    var str = "";
    var i = 0;
    $("input[name=items]:checkbox").each(function () {
        if ($(this).is(":checked"))
        {
            ids[i] = $(this).attr("value");
            str += $(this).attr("value-num") + ",";
            i++;
        }
    });

    if (i == 0) {
        selfalert('<h1>警告</h1>', '请选择要装车的货单！');
        return;
    } else {
        str = str.substring(0, str.length - 1);
        $('#confirmInfo').html('确定要将编号为 ' + str + '的货装车？');

        $('#my-confirm').modal({
            relatedTarget: this,
            onConfirm: function () {
                $.ajax({
                    //几个参数需要注意一下
                    type: "POST", //方法类型
                    dataType: "json", //预期服务器返回的数据类型
                    url: "/admin/index/goodstocar.html",
                    data: {"id": ids},
                    success: function (result) {
                        if (result.code == 200) {
                            window.location.reload();
                        }
                        if (result.code == 0) {
                            alert(result.data);
                            window.location.reload();
                        }
                        ;
                    },
                    error: function () {
                        alert("网络错误，稍后重试！");
                    }
                });
            },
            onCancel: function () {

            }
        });

    }
});
