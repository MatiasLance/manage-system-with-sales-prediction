$(document).ready(function () {
    let rowsPerPage = 5; // Number of rows per page
    let currentPage = 1;
    let rows = $("#tableBody tr");
    let totalPages = Math.ceil(rows.length / rowsPerPage);

    function showPage(page) {
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        rows.hide().slice(start, end).show();

        // Update pagination controls
        $("#currentPage").text(page);
        $("#prevPage").parent().toggleClass("disabled", page === 1);
        $("#nextPage").parent().toggleClass("disabled", page === totalPages);
    }

    // Initial table load
    showPage(currentPage);

    // Pagination button clicks
    $("#prevPage").click(function (e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    $("#nextPage").click(function (e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    // Search filter
    $("#searchInput").on("keyup", function () {
        let value = $(this).val().toLowerCase();
        rows.each(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

        // Recalculate pagination after search
        let filteredRows = rows.filter(":visible");
        totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        currentPage = 1;
        showPage(currentPage);
    });
});