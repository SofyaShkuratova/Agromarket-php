$(document).ready(function () {
    $(".btn-success").click(function (event) {
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();
        var formData = {
            title: $("#title").val(), 
            text: $("#comment").val(),
            product_id: $(".product").attr("id_product"), 
        };

      // console.log("helllo");  
  
      $.ajax({
        type: "POST",
        url: "comment.php", 
        data: formData, 
        dataType: "json",
        // encode: true,
        success: function(data) {
          console.log(data);
          if(data.error === 1){
              alert("Запольните все поля!");
          } else if(data.error === 0) {
              alert("Комментарий добавлен!");
              // $(".row-cont").append(
              //     '<div class="help-block">' + data.errors + "</div>"
              // );

          } else {
            alert("Пользователь не авторизирован!");
          }


        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR,textStatus, errorThrown);
        }
      })
      // .done(function (data) {
      // console.log(data);

        // if (!data.success) {
        //     if (data.errors.title) {
        //       $("#name-group").addClass("has-error");
        //       $("#name-group").append(
        //         '<div class="help-block">' + data.errors.title + "</div>"
        //       );
        //     }
    
        //     if (data.errors.text) {
        //       $("#email-group").addClass("has-error");
        //       $("#email-group").append(
        //         '<div class="help-block">' + data.errors.text + "</div>"
        //       );
        //     }
    
        //   } else {
        //     $(".row-cont").html(
        //     //   '<div class="alert alert-success">Данные успешно добавлены</div>'
        //     );
        //   }
      });
  
      // event.preventDefault();
  });

  // });