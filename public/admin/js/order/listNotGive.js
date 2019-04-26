$(function () {
    getLists()





});


function getLists(page = 1, pageSize = 10) {
    $.ajax({
        url: "/admin/orderapi/lists",
        type: "POST",
        // data: $("#submit-form").serialize(),
        dataType: "json",
        context: document.body,
        success: function (data) {
            if(data.code === 200){
                addFormHtml(data.data)
            }
        }
    })
}

function addFormHtml(data) {
    $.each(data, function (index,item) {
        $("#formListData").append(dataForm(item))
    })
}
// actual_price: "0.00"
// admin_id: 1
// arrears_price: null
// created_at: "2019-04-24 16:53:07"
// has_pay_price: null
// has_price: null
// id: 1
// invoicing_price: null
// location: null
// number: "1-1"
// pay_way: 0
// post_price: null
// price: "10.00"
// status: 1
// updated_at: "2019-04-24 16:53:18"
/**
 * 数据模板
 * @param data
 * @returns {string}
 */
function dataForm(data) {
    var html = ' <tr>\n' +
        '                <td class="am-text-middle">\n' +
        '                    <div>'+ data.id +'</div>\n' +
        '                    <h2>姓名：'+ data.customer_name +'</h2>\n' +
        '                    <h3>编号：'+ data.number +'</h3>\n' +
        '\n' +
        '                    <div>'+ data.froms +'->'+ data.tos +'</div>\n' +
        '                </td>\n' +
        '                <td>\n' +
        '                    <ul class="am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-thumbnails">\n' +
        '                        <li>代收：'+data.price  +' </li>\n' +
        '                        <li>已收：'+ data.has_price +'</li>\n' +
        '                        <li>中转：'+ data.has_pay_price +'</li>\n' +
        '                        <li>直送：'+ data.post_price +'</li>\n' +
        '                        <li>代收款：'+ data.invoicing_price +'</li>\n' +
        '                        <li>欠款：'+ data.arrears_price +'</li>\n' +
        '                    </ul>\n' +
        '                    <div>手机号：'+ data.customer_phone +'</div>\n' +
        '                    <div>直送地址：普陀区同普路1272号</div>\n' +
        '                </td>\n' +
        '                <td>\n' +
        '                    <form class="am-form" style="width: 70px">\n' +
        '                        <div class="am-form-group">\n' +
        '                            <label>实收金额</label>\n' +
        '                            <input type="number" class="money-full">\n' +
        '                        </div>\n' +
        '                        <div>\n' +
        '                            <label class="am-radio">\n' +
        '                                <input type="radio" name="radio1" value="" data-am-ucheck>\n' +
        '                                现金\n' +
        '                            </label>\n' +
        '                            <label class="am-radio">\n' +
        '                                <input type="radio" name="radio1" value="" data-am-ucheck checked>\n' +
        '                                微信\n' +
        '                            </label>\n' +
        '                            <label class="am-radio">\n' +
        '                                <input type="radio" name="radio1" value="" data-am-ucheck checked>\n' +
        '                                支付宝\n' +
        '                            </label>\n' +
        '                        </div>\n' +
        '                        <div style="text-align: right">\n' +
        '                            <button type="submit" class="am-btn am-btn-secondary am-btn-xs am-round">提交</button>\n' +
        '                        </div>\n' +
        '                    </form>\n' +
        '                </td>\n' +
        '            </tr>'
    return html;

}