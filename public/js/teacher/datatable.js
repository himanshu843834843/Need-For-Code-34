var initTeacherDataTable = function(route) {
    console.log($('meta[name="csrf-token"]').attr('content'))
    $('#TeacherDataTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: route,
            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content') ,
                // "_token": "{{ csrf_token() }}",
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
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            }
        ],
        order:[
            [1,'asc'],
        ],
    });
};
