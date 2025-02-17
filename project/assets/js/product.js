$(document).ready(function() {
    let debounceTimer; // Timer for debouncing
    let currentSearch = ''; // Store last search value

    function fetchData(page, searchQuery) {
        $.ajax({
            url: 'fetch_data.php', // PHP file to fetch data
            type: 'GET',
            data: { page: page, search: searchQuery },
            dataType: 'json',
            success: function(response) {
                // Populate table with fetched data
                $('#data-container').empty();
                response.data.forEach(function(item) {
                    $('#data-container').append(`<tr>
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.email}</td>
                    </tr>`);
                });

                // Generate pagination links
                $('#pagination-links').empty();
                for (let i = 1; i <= response.total_pages; i++) {
                    $('#pagination-links').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }
            },
            error: function() {
                alert('Error loading data');
            }
        });
    }

    // Initial fetch
    fetchData(1, '');

    // Pagination click event
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        fetchData(page, currentSearch);
    });

    // Debounced search input event
    $('#search-input').on('keyup', function() {
        clearTimeout(debounceTimer); // Clear previous timer
        let searchQuery = $(this).val();

        debounceTimer = setTimeout(() => {
            currentSearch = searchQuery; // Update current search
            fetchData(1, searchQuery); // Fetch data after 5 seconds
        }, 5000); // 5-second debounce
    });
});