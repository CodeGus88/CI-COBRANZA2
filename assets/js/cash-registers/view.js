function tableBuilder(tableName, url, columns, lengthMenu) {
    $(document).ready(function () {
        $(`#${tableName}`).dataTable().fnDestroy();
        $(`#${tableName}`).dataTable({
            "lengthMenu": [lengthMenu, lengthMenu],
            'paging': true,
            'info': true,
            'filter': true,
            'stateSave': true,
            'processing': true,
            'serverSide': true,
            'ajax': {
                "url": url,
                "type": "POST"
            },
            'columns': columns
        });
    });
}

const cash_register_id = document.getElementById('id').value;
const lengthMenu = [2, 5, 10, 20, 50, 100];
const method = "${method}";
const partialUrl = base_url + `admin/cashRegister/${method}/${cash_register_id}`;

// Para las tablas manualInputs y manualOutputs
const manual_columns = [
    { data: 'id', 'sClass': 'text-center'},
    { data: 'amount'},
    { data: 'description'},
    { data: 'date'}
];

tableBuilder("manual-inputs", partialUrl.replace(method, 'ajax_manual_inputs'), manual_columns, lengthMenu);
tableBuilder("manual-outputs", partialUrl.replace(method, 'ajax_manual_outputs'), manual_columns, lengthMenu);

// operaciones;
const document_payment_colums = [
    // { data: 'id', 'sClass': 'text-center'},
    {'id': true, 'sClass': 'text-center', 
        render: function(data, type, row){
            return `<a href="${base_url}admin/payments/document_payment/${row.id}" target="_blank">${row.id}</a>`;
        }
    },
    { data: 'customer_name'},
    { data: 'amount'},
    { data: 'pay_date'}
];
const loan_columns = [
    { data: 'id', 'sClass': 'text-center'},
    { data: 'customer_name'},
    { data: 'credit_amount'},
    { data: 'date'}
];
tableBuilder("manual-inputs", partialUrl.replace(method, 'ajax_manual_inputs'), manual_columns, lengthMenu);
tableBuilder("manual-outputs", partialUrl.replace(method, 'ajax_manual_outputs'), manual_columns, lengthMenu);
tableBuilder("document-payment-inputs", partialUrl.replace(method, 'ajax_document_payment_inputs'), document_payment_colums, lengthMenu);
tableBuilder("loan-outputs", partialUrl.replace(method, 'ajax_loan_outputs'), loan_columns, lengthMenu);
