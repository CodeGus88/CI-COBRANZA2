// Cargar lista paginable
function loadData() {
    $(document).ready(function () {
        // Consultar cuotas del préstamo
        user_id = document.getElementById('userSelector').value != 'all'?'/'+document.getElementById('userSelector').value:'';
        $("#cash-registers").dataTable().fnDestroy();
        // $("#cash-registers").dataTable().destroy();0
        $('#cash-registers').dataTable({
            "lengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
            'paging': true,
            'info': true,
            'filter': true,
            'stateSave': true,

            'processing': true,
            'serverSide': true,

            'ajax': {
                "url": base_url + "admin/cashRegister/ajax_loas_cash_registers/" + user_id,
                "type": "POST"
            },
            'columns': [
                { data: 'name', 'sClass': 'dt-body-center' },
                { data: 'user_name' },
                { data: 'total_mount' },
                { data: 'opening_date' },
                { data: 'closing_date' },
                {
                    'cell': true,
                    render: function (data, type, row) {
                        if(row.status==1)
                            return `<button class="btn btn-success btn-sm">Abierto</button>`;
                        else
                            return `<button class="btn btn-warning btn-sm">Cerrado</button>`;
                    }
                }
            ],
            "order": [[1, "desc"]]
        });
    });

}

if(document.getElementById( "userSelector" )){
    const userSelector = document.getElementById('userSelector');
    userSelector.addEventListener('change', (event) => {
        loadData();
    });
}

loadData();


