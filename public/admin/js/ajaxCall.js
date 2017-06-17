    $("#aboutUs").click(function(e){
        e.preventDefault();
        var text =document.getElementById("editor").innerHTML;
        var data = {
            "_token": $('#token').val(),
            'aboutUs':text,
            'type':"aboutUs"
        }

        $.ajax({
            type: "POST",
            url : "/admin/about/aboutus",
            data : data,
            cache : false,
            dataType:"json",
            success :function(data) {
                console.log('data');
            },
            error: function(data){
                console.log(data);
            }
        },"json");
    });
