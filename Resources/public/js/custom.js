$("#file").change(function () {
    var file = this.files[0];
    name = file.name;
    size = file.size;
    type = file.type;
    if (file.name.length < 1) {
    }
    else if (file.size > 1000000) {
        alert("File is to big");
    }
    else if (file.type != 'image/jpg' && file.type != 'image/jpeg') {
        alert("File doesnt match jpg");
    }
    else {
        var formData = new FormData($('form')[0]);
        var url = Routing.generate('media_json_upload');
        $.ajax({
            url: url, //server script to process data
            type: 'POST',
            xhr: function () {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                //Upload progress
                myXhr.upload.addEventListener("progress", function () {
                    //Do something with upload progress
                    $(".se-pre-con").css("display", "block");
                }, false);
                return myXhr;
            },
            //Ajax events
            success: completeHandler = function (data) {
                destroyJCrop();
                initJCrop(data.asset);
                $(".se-pre-con").fadeOut("slow");
                $("#name").val(data.name);
                $("#directory").val(data.directory);
                $("#_submit").attr("disabled", false);
            },
            error: errorHandler = function () {
                alert("an error occured");
            },
            // Form data
            data: formData,
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            async: false,
            processData: false
        }, 'json');
    }
});