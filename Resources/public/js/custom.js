$("#file").change(function () {
    var file = this.files[0];

    console.log(file);
    name = file.name;
    size = file.size;
    type = file.type;
    var route = $(this).data("route");
    var id = $(this).data("id");
    if (file.name.length < 1) {
    }
    else if (file.size > 1000000) {
        alert("File is to big");
    }
    else if (file.type != 'image/jpg' && file.type != 'image/jpeg') {
        alert("File doesnt match jpg");
    }
    else {
        //var form = $(this).closest("form");
        //var form = $(this).closest('form');
        var formData = new FormData(this.form);
        var url;
        if (id) {
            url = Routing.generate(route, {id: id});
        }
        else {
            url = Routing.generate(route);
        }

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
                $(".se-pre-con").fadeOut("slow");//TODO
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
            processData: false
        }, 'json');
    }
});