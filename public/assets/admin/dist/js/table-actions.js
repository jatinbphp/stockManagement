$(function () {
    //User Table
    var users_table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', "width": "15%", name: 'name'},
            {data: 'email',  name: 'email'},
            {data: 'phone',  name: 'phone'},
            {data: 'image',  name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },
            {data: 'status',  name: 'status', orderable: false},    
            {data: 'action',  name: 'action', orderable: false},                
        ]
    });

    //Category Table
    var category_table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'categoryName', "width": "55%", categoryName: 'categoryName'},
            {data: 'image', "width": "15%", name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },
            {data: 'status',  name: 'status', orderable: false},
            {data: 'action',  name: 'action', orderable: false},
        ]
    });

    //Product Table
    var products_table = $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'product_name', product_name: 'product_name'},
            {data: 'sku',  name: 'sku'},
            {data: 'status',  name: 'status', orderable: false},
            {data: 'action',  name: 'action', orderable: false},
        ]
    });

    //Option Table
    var options_table = $('#optionsTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', "width": "55%", name: 'name'},
            {data: 'status',  name: 'status'},
            {data: 'action',  name: 'action'},
        ]
    });

    //CMS Table
    var content_table = $('#contentTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'title', name: 'title'},
            {data: 'action',  name: 'action', orderable: false},                
        ]
    });

    //Contact Us Table
    var contactus_table = $('#contactusTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'message', name: 'message'},
            {data: 'action',  name: 'action', orderable: false},                
        ]
    });

    //Order Table 
    var orders_table = $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [100, 200, 300, 400, 500],
        ajax: $("#route_name").val(),
        columns: [
            { data: 'order_id', name: 'order_id'},
            { data: 'user_name', name: 'user_name'},
            { data: 'user_email', name: 'user_email'},
            { data: 'total_amount', name: 'total_amount'},
            { data: 'status', name: 'status', orderable: false},
            { data: 'action', name: 'action', orderable: false},

        ]
    });

    //Order Product Table 
    var orders_products_table = $('#orderProductTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [100, 200, 300, 400, 500],
        ajax: $("#route_name").val(),
        columns: [
            { data: 'product_name', name: 'product_name' },
            { data: 'sku', name: 'sku' },
            { data: 'quantity', name: 'quantity' },
            { data: 'unit_price', name: 'unit_price' },
            { data: 'total', name: 'total' },
            //{ data: 'action', name: 'action' },

        ]
    });

    //Delete Record
    $('.datatable-dynamic tbody').on('click', '.deleteRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        var section = $(this).attr("data-section");

        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){
                        if(section=='users_table'){
                            users_table.row('.selected').remove().draw(false);    
                        } else if(section=='category_table'){
                            category_table.row('.selected').remove().draw(false);   
                        } else if(section=='products_table'){
                            products_table.row('.selected').remove().draw(false);   
                        } else if(section=='options_table'){
                            options_table.row('.selected').remove().draw(false);   
                        } else if(section=='contactus_table'){
                            contactus_table.row('.selected').remove().draw(false);   
                        } else if (section == 'orders_table') {
                            orders_table.row('.selected').remove().draw(false);
                        }
                 
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });

    //Change Status
    $('.datatable-dynamic tbody').on('click', '.assign_unassign', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        var table_name = $(this).attr("data-table_name");
        var section = $(this).attr("data-table_name");

        var l = Ladda.create(this);
        l.start();
        $.ajax({
            url: url,
            type: "post",
            data: {
                'id': id,
                'type': type,
                'table_name': table_name,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                l.stop();

                if(type=='unassign'){
                    $('#assign_remove_'+id).hide();
                    $('#assign_add_'+id).show();
                } else {
                    $('#assign_remove_'+id).show();
                    $('#assign_add_'+id).hide();
                }

                if(section=='users_table'){
                    users_table.draw(false);
                } else if(section=='products_table'){
                    products_table.draw(false);   
                } else if(section=='products_table'){
                    products_table.draw(false);   
                } else if(section=='options_table'){
                    options_table.draw(false);   
                } 
            }
        });
    });
});

