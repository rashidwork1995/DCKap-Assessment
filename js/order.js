var order_list=$("#order_table").DataTable({
    paging: true, 
   "bInfo": true, 
   searching: false,
   lengthMenu: [ [10, 30, 50, 100, 500], [10, 30, 50, 100, 500] ],
   pageLength: 30,
   "bSort": true,
   'processing': false,
   'serverSide': true,
   "ajax":{
       url: 'inc/dckap_operation.php',                        
       type: "post",  // method  , by default get
       "data": function ( data ) {
           data.method="view_orders";
           data.search_customer= $("#search_order").val();
       },
   }
});
$("#search_order").keyup(function(event) {
    order_list.ajax.reload();
});