var customer_list=$("#customer_table").DataTable({
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
			data.method="view_user";
			data.search_customer= $("#search_customer").val();
		},
	}
});
$("#search_customer").keyup(function(event) {
    customer_list.ajax.reload();
});