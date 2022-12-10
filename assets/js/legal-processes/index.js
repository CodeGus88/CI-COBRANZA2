// Cargar lista paginable
function loadData() {
    $(document).ready(function () {
        $("#legal-precesses").dataTable().fnDestroy();
        $('#legal-precesses').dataTable({
            "lengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
            'paging': true,
            'info': true,
            'filter': true,
            'stateSave': true,
            'processing': true,
            'serverSide': true,
            'ajax': {
                "url": base_url + "admin/legal_processes/ajax_legal_processes",
                "type": "POST"
            },
            'columns': [
                { data: 'id', 'sClass': 'text-right' },
                { data: 'customer'},
                { data: 'start_date'},
                {
                    'cell': true,
                    render: function (data, type, row) {
                        const VIEW_URL = `${base_url}admin/legal_processes/view/${row.id}`;
                    return `
                        <a class="btn btn-info btn-circle btn-sm" href="${VIEW_URL}" title="Ver"><i class="fas fa-info-circle" title="Ver"></i></a>
                    `;  
                    }, sClass: 'text-center'
                },
            ],
            "order": [[0, "asc"]]
        });
    });
}

if(document.getElementById( "user_id" )){
    const userSelector = document.getElementById('user_id');
    userSelector.addEventListener('change', (event) => {
        loadData();
    });
}

loadData();

