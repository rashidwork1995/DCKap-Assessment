$( document ).ready(function() {
    $("#add_product").validate({
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
            product_name: {
                required: true,
            },
            customer_price: {
                required: true,
            },
            guest_price: {
                required: true,
            },
            image:
            {
                required: true,
            },
        },
        messages: { 
            product_name: {
                required: 'Product Name should not be an empty',
            },
            customer_price: {
                required: 'Customer Price Should not be an empty',
            }, 
            guest_price: {
                required: "Guest Price Number Should not be an empty",
            },
            image:
            {
                required: "Image Should not be an empty",
            },                      
        }, 
        errorElement: "span",
        errorClass: "error",
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url: 'inc/dckap_operation.php',
                method: 'POST',
                data:formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(result) {
                    swal(result.val, result.messsage, (result.status == 0 ? 'success' : 'error'));
                    if(result.status==0)
                    {
                        $('#add_product')[0].reset(); 
                        window.location = 'index.php';
                    }
                }
            });
        },
        
    });
});

