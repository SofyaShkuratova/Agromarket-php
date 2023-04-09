$(document).ready(function () {
    var formData = {
        title: $("#title").val(), 
        text: $("#comment").val(),
        product_id: $(".product").attr("id_product"), 
    };

    load_comment();

    function load_comment(){
        $.ajax({
            url:"fetch_comment.php",
            type:"POST",
            data: formData, 

            success:function(data)
            {
            $('#display_comment').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR,textStatus, errorThrown);
            }
        })
    }
    
    $(".btn-success").click(function (event) {
        
        var formData = {
            title: $("#title").val(), 
            text: $("#comment").val(),
            product_id: $(".product").attr("id_product"), 
        };
        
        $.ajax({
            type: "POST",
            url: "add_comment.php", 
            data: formData, 
            dataType: "json",
            success: function(data) {
                console.log(data);
                if(data.error === 1){
                    alert("Запольните все поля!");
                } else if(data.error === 0) {
                    alert("Комментарий добавлен!");
                    load_comment();
                } else {
                  alert("Пользователь не авторизирован!");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR,textStatus, errorThrown);
            }
        })
    
        
    });
});


 