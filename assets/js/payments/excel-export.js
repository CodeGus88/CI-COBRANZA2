function exportExcel() {
    let linkDescarga;
    let tipoDatos = 'application/vnd.ms-excel';
    let tablaDatos = document.getElementById('table_content');
    let tablaHTML = tablaDatos.outerHTML.replace(/ /g, '%20');

    // Nombre del archivo
    nombreArchivo = USER_NAME.split(" ").join("_").split(".").join("")  + '.xls';

    // Crear el link de descarga
    linkDescarga = document.createElement("a");

    document.body.appendChild(linkDescarga);

    if (navigator.msSaveOrOpenBlob) {
        let blob = new Blob(['\ufeff', tablaHTML], {
            type: tipoDatos
        });
        navigator.msSaveOrOpenBlob(blob, nombreArchivo);
    } else {
        // Crear el link al archivo
        linkDescarga.href = 'data:' + tipoDatos + ', ' + tablaHTML;

        // Setear el nombre de archivo
        linkDescarga.download = nombreArchivo;

        //Ejecutar la función
        linkDescarga.click();
    }
}