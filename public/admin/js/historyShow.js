$(document).ready(function(){
    $.ajax({
        url: "getList",
        type: "POST",
        data: {

        },
        dataType: "json",
        context: document.body,
        success: function (data) {
            if(data.code == 200){
                console.log(data)
                if(data.data.total > 0){
                    var datas = data.data.data
                    datas.forEach(function (item) {
                        console.log(item)
                        var html = '<tr class="">\n' +
                            '                    <td>' +  item.id +  '</td>\n' +
                            '                    <td> ' + item.date + ' </td>\n' +
                            '                    <td>'+ item.name +'/'+ item.phone   + '</td>\n' +
                            '                    <td>'+ item.number +'</td>\n' +
                            '                    <td>'+ item.city +'</td>\n' +
                            '                    <td>' +  item.post_date + '</td>\n' +
                            '                </tr>'

                        $('#form-data').append(html);
                    })
                    // data.data.data.each(function (item) {
                    //     console.log(item)
                    // })
                }
            }
        }
    });
})



