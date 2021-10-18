$( document ).ready(function() {
        var data = new FormData();
         data.append("method", "customer_address");
         $.ajax({
         url: 'inc/dckap_operation.php',
         method: 'POST',
         processData: false,
         contentType: false,
         cache: false,
         data: data,
         dataType: 'json',
         success: function(response) {
            $('#name').val(response.name);
            $('#mobile_number').val(response.mobile_number);
            $('#address').val(response.address);
         }
        });
        var data_cart = new FormData();
        data_cart.append("method", "view_cart");
        data_cart.append("page", "checkout_page");
        $.ajax({
        url: 'inc/dckap_operation.php',
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: data_cart,
        dataType: 'json',
        success: function(response) {
            $('#cart_val tbody').append(response.data);
        }
        });
        $(document).on('click', ".order-placed", function() {
            var data_cart = new FormData();
            var subtotal=$('#subtotal').val();
            data_cart.append("method", "add_order");
            data_cart.append("total_amount", subtotal);
            $.ajax({
            url: 'inc/dckap_operation.php',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: data_cart,
            dataType: 'json',
            success: function(response) {
                swal(response.val, response.messsage, (response.status == 0 ? 'success' : 'error'));
                window.location = 'index.php';
            }
            });
        });
});