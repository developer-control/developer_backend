function initializeDatatable(element, url, columnValues) {
    return $(element).DataTable({
        autoWidth: false,
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
                // display: $.fn.dataTable.Responsive.display.childRowImmediate
            }
        },
        // scrollY: '400px',
        // scrollCollapse: true,
        responsive: false,
        processing: true,
        serverSide: true,
        ajax: url,
        columns: columnValues
        // ajax: "/access-users/role-datatable",
        // columns: [{
        //         data: 'name',
        //         name: 'name'
        //     },
        //     {
        //         data: 'guard_name',
        //         name: 'guard_name'
        //     },
        //     {
        //         data: 'action',
        //         name: 'action',
        //         orderable: false,
        //         searchable: false
        //     }
        // ]
    });
}