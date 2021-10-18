$( document ).ready(function() {
    view_cart();
    $("#register_form").validate({
        errorPlacement: function (error, element) {
            if (element.parent(".input-group").length) {
                error.insertAfter(element.parent());
            } else if (element.hasClass("floating-labelSrc")) {
                error.insertBefore(element.next("span"));
                element.next().next("span").addClass("error");
            } else {
                error.insertAfter(element);
            }
        },
        ignore: [],
        onfocus: true,
        rules: {  
            name: {
                required: true,
            },
            email: {
                required: true,
            },
            mobile_number: {
                required: true,
                maxlength: 10,
                minlength: 10,
            },
            password:
            {
                required: true,
                minlength: 5,
                maxlength: 30,
            },
            address: {
                required: true,
            },
        },
        messages: { 
            name: {
                required: 'Name should not be an empty',
            },
            email: {
                required: 'Email Should not be an empty',
            }, 
            mobile_number: {
                required: "Mobile Number Should not be an empty",
                maxlength: "Mobile Number shoould be 10 Character",
                minlength: "Mobile Number shoould be 10 Character",
            },
            password:
            {
                required: "Password Should not be an empty",
                minlength: "Password should be min of 5 characters!",
                maxlength: "pasword should not be max of 30 characters!",
            },
            address:
            {
                required: "Address Should not be an empty",
            },                       
        }, 
        errorElement: "span",
        errorClass: "error",
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url: 'inc/dckap_operation.php',
                method: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                dataType: 'json',
                success: function(result) {
                    swal(result.val, result.messsage, (result.status == 0 ? 'success' : 'error'));
                    if(result.status==0)
                    {
                        $('#signin-modal').modal('hide');
                        $('#register_form')[0].reset(); 
                        window.location = 'index.php';
                    }
                }
            });
        },
    });

    $("#login_form").validate({
        errorPlacement: function (error, element) {
            if (element.parent(".input-group").length) {
                error.insertAfter(element.parent());
            } else if (element.hasClass("floating-labelSrc")) {
                error.insertBefore(element.next("span"));
                element.next().next("span").addClass("error");
            } else {
                error.insertAfter(element);
            }
        },
        ignore: [],
        onfocus: true,
        rules: {  
            singin_username: {
                required: true,
            },
            singin_password: {
                required: true,
            },
        },
        messages: { 
            singin_username: {
                required: 'Username should not be an empty',
            },
            singin_password: {
                required: 'Password Should not be an empty',
            },                       
        }, 
        errorElement: "span",
        errorClass: "error",
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url: 'inc/dckap_operation.php',
                method: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                dataType: 'json',
                success: function(result) {
                    if(result.status==1)
                    {
                        swal(result.val, result.messsage, (result.status == 0 ? 'success' : 'error'));
                        $('#login_form')[0].reset(); 
                    }
                    else if(result.status==0)
                    {
                        window.location = 'index.php';
                    }
                }
            });
        }
        
    });
    $(".num").bind("keypress", function (e) {
        var keyCode = e.which ? e.which : e.keyCode
        if (!(keyCode >= 48 && keyCode <= 57)) {
          $(".error").css("display", "inline");
          return false;
        }else{
          $(".error").css("display", "none");
        }
    });
        var data = new FormData();
         data.append("method", "product_view");
         $.ajax({
         url: 'inc/dckap_operation.php',
         method: 'POST',
         processData: false,
         contentType: false,
         cache: false,
         data: data,
         dataType: 'json',
         success: function(response) {
            $('#prod_val').html(response.data);
         }
        });
        $(document).on('click', ".addcart", function() {
            var data_cart= new FormData();
            var product_id=$(this).attr('data-id');
            var qty=$('#qty'+product_id).val();
            data_cart.append("method", "add_cart");
            data_cart.append("qty", qty);
            data_cart.append("product_id", product_id);
            $.ajax({
                url: 'inc/dckap_operation.php',
                method: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: data_cart,
                dataType: 'json',
                success: function(response) {
                    if(response.f==0){
                        $('#signin-modal').modal('show');
                    }else{
                        swal(response.val, response.messsage, (response.status == 0 ? 'success' : 'error'));
                        
                    }
                }
            });
            view_cart();    
        });
        $(document).on('click', ".remove-prod", function() {
            alert('hi');
            var data_cart= new FormData();
            var product_id=$(this).attr('data-id');
            data_cart.append("method", "deletecart");
            data_cart.append("cart_id", product_id);
            $.ajax({
                url: 'inc/dckap_operation.php',
                method: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: data_cart,
                dataType: 'json',
                success: function(response) {
                    if(response.f==0){
                        $('#signin-modal').modal('show');
                    }else{
                        swal(response.val, response.messsage, (response.status == 0 ? 'success' : 'error'));
                    }
                }
            });
            view_cart();    
        });
});
function view_cart(){
    var data_cart = new FormData();
    data_cart.append("method", "view_cart");
    data_cart.append("page", "product_page");
     $.ajax({
     url: 'inc/dckap_operation.php',
     method: 'POST',
     processData: false,
     contentType: false,
     cache: false,
     data: data_cart,
     dataType: 'json',
     success: function(response) {
        $('#cart_val').html(response.data);
     }
    });
} 