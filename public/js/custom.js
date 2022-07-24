function makeApiCall(url, parameters, successCallback,loader, method='POST', errorCallback = null) {
    $.ajax({
        beforeSend: function () {
            if (loader) {
                loader.show();
            }
        },
        complete: function () {
            if (loader) {
                loader.hide();
            }
        },
        type: method,
        url: url,
        data: parameters,
        // contentType: 'application/json;',
        dataType: 'json',
        success: successCallback,
        error: errorCallback ? errorCallback : function (xhr, textStatus, errorThrown) {
            // console.log(errorThrown);
        }
    });
}

function makeApiCallWithFiles(url, parameters, successCallback,loader, method='POST', errorCallback = null) {
    $.ajax({
        beforeSend: function () {
            if (loader) {
                loader.show();
            }
        },
        complete: function () {
            if (loader) {
                loader.hide();
            }
        },
        type: method,
        url: url,
        data: parameters,
        // contentType: 'application/json;',
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        dataType: 'json',
        success: successCallback,
        error: errorCallback ? errorCallback : function (xhr, textStatus, errorThrown) {
            // console.log(errorThrown);
        }
    });
}

function apiCallServerErrorMessage(xhr,defaultMessage){
    if([400,409,401,403,422].includes(xhr.status)){
        if(Array.isArray(xhr?.responseJSON?.message)){
            let message="";
            xhr?.responseJSON?.message.map(function (item) {
                message+=item+',';
            });

            return message;
        }
        return xhr?.responseJSON?.message;
    }

    return defaultMessage;
}