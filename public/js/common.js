function request(url, type, data, callback, token) {
    var headers = {};
    if (token) {
        headers.Authorization = token;
    }
    $.ajax({
        url: url,
        type: type,
        data: data,
        success: function (data) {
            callback(data);
        },
        headers: headers,
        error: function (xhr) {
            console.log(xhr);
            if (xhr.responseJSON.errors) {
                for (var item in xhr.responseJSON.errors) {
                    for (var j = 0; j < xhr.responseJSON.errors[item].length; j++) {
                        alert(xhr.responseJSON.errors[item][j]);
                        return;
                    }
                }
            } else {
                alert(xhr.responseJSON.message);
            }
        }
    });
}