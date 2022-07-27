var initUserDataTable = function(route) {
    $('#UserDataTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: route,
            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content') ,
            }
        },
        columns: [
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            },
            {
                data: 'id',
                name: 'Id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email',
            }
        ],
        order:[
            [1,'asc'],
        ],
    });
};
