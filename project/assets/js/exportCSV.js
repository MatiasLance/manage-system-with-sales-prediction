jQuery(function($){
    $('#exportCSV').on('click', function(){
        exportAllTablesToCSV($);
    });
});

function exportAllTablesToCSV() {
  const table = jQuery('#inventoryTable')[0];

  if (!table) {
    Swal.fire({
        title: 'Warning',
        text: 'Table with ID "inventoryTable" not found!',
        icon: 'warning',
    }).then((result) => {
        if(result.isConfirmed){
          return;
        }
    });
  }

  const worksheet = XLSX.utils.table_to_sheet(table);

  const workbook = XLSX.utils.book_new();
  const sheetName = 'Inventory';

  const safeName = sheetName.substring(0, 31)
    .replace(/[^a-zA-Z0-9_]/g, '_')
    .replace(/^_+|_+$/g, ''); 

  XLSX.utils.book_append_sheet(workbook, worksheet, safeName);

  XLSX.writeFile(workbook, 'inventory.xlsx');
}
