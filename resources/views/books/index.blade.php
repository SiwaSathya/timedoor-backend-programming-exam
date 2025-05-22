<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Spinner */
        .spinner-border {
            width: 3rem;
            height: 3rem;
            border: 0.3em solid rgba(255, 255, 255, 0.3);
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spinner 1.5s linear infinite;
        }

        @keyframes spinner {
            to { transform: rotate(360deg); }
        }

        /* Overlay for loading */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            display: none; /* Hidden by default */
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <a href="{{ url('/top-authors') }}" class="btn btn-success mb-3">Go to Top 10 Authors</a>
        <br>
        <a href="{{ url('/rating-author-book') }}" class="btn btn-success mb-3">Vote You're Favorite Author</a>
        <br>
        <h1>Books List</h1>

        <!-- Search Form -->
        <form id="searchForm" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="searchQuery" class="form-control" placeholder="Search by book or author">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary w-100" onclick="searchBooks()">Search</button>
                </div>
                <div class="col-md-3">
                    <select id="perPage" class="form-select" onchange="searchBooks()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Books Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>  <!-- Kolom No -->
                    <th>Book Name</th>
                    <th>Book Category</th>
                    <th>Author</th>
                    <th>Avg Rating</th>
                    <th>Voters</th>
                </tr>
            </thead>
            <tbody id="booksTableBody">
                <!-- Data will be populated here via JS -->
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination" id="paginationLinks">
                <!-- Pagination links will be populated here -->
            </ul>
        </nav>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border" role="status"></div>
    </div>

    <script>

        function searchBooks(page = 1) {
            const searchQuery = document.getElementById('searchQuery').value;
            const perPage = document.getElementById('perPage').value;
            const url = `http://127.0.0.1:8000/api/books-index?search=${searchQuery}&perPage=${perPage}&page=${page}`;


            document.getElementById('loadingOverlay').style.display = 'flex';

            fetch(url)
                .then(response => response.json())
                .then(data => {

                    const booksTableBody = document.getElementById('booksTableBody');
                    booksTableBody.innerHTML = '';

                    let index = (page - 1) * perPage;

                    data.data.data.forEach(book => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${++index}</td>  <!-- Increment No column -->
                            <td>${book.book_name}</td>
                            <td>${book.book_categories.categories_name}</td>
                            <td>${book.author.name}</td>
                            <td>${book.avg_rating}</td>
                            <td>${book.voter}</td>
                        `;
                        booksTableBody.appendChild(row);
                    });


                    const paginationLinks = document.getElementById('paginationLinks');
                    paginationLinks.innerHTML = '';

                    data.data.links.forEach(link => {
                        if (link.url) {
                            const listItem = document.createElement('li');
                            listItem.classList.add('page-item');
                            listItem.classList.toggle('active', link.active);
                            listItem.innerHTML = `<a class="page-link" href="#" onclick="searchBooks(${link.url.split('=')[1]})">${link.label}</a>`;
                            paginationLinks.appendChild(listItem);
                        }
                    });


                    document.getElementById('loadingOverlay').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById('loadingOverlay').style.display = 'none';
                });
        }


        document.addEventListener('DOMContentLoaded', function() {
            searchBooks();
        });
    </script>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
