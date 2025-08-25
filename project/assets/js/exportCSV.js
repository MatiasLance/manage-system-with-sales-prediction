jQuery(function($){
    $('#exportCSV').on('click', function(){
        exportAllTablesToCSV($);
    });
});

function exportAllTablesToCSV($) {
 const workbook = XLSX.utils.book_new();

  $('#inventoryTable').each(function () {
    const table = $(this);
    const tableName = table.attr('id') || 'Sheet';
    
    const worksheet = XLSX.utils.table_to_sheet(this, { sheet: tableName });

    const data = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
    
    const safeName = (tableName.substring(0, 31)).replace(/[^a-zA-Z0-9_]/g, '_');
    XLSX.utils.book_append_sheet(workbook, XLSX.utils.json_to_sheet(data), safeName);
  });

  XLSX.writeFile(workbook, 'inventory.xlsx');
}


