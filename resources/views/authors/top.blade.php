<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 Authors</title>
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
        <h1>Top 10 Authors</h1>

        <!-- Tombol untuk kembali ke halaman utama -->
        <a href="{{ url('/') }}" class="btn btn-secondary mb-3">Back to Books List</a>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="spinner-border" role="status"></div>
        </div>

        <!-- Authors Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Author Name</th>
                    <th>Voters</th>
                </tr>
            </thead>
            <tbody id="authorsTableBody">
                <!-- Data will be populated here via JS -->
            </tbody>
        </table>
    </div>

    <script>
        // Function to fetch top authors
        function loadTopAuthors() {
            const url = "http://127.0.0.1:8000/api/authors";  // Endpoint API untuk top authors

            // Show loading overlay
            document.getElementById('loadingOverlay').style.display = 'flex';

            // Fetch data from the API
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const authorsTableBody = document.getElementById('authorsTableBody');
                    authorsTableBody.innerHTML = '';  // Clear existing rows

                    let index = 1; // Start numbering from 1
                    data.data.forEach(author => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index++}</td>
                            <td>${author.author_name}</td>
                            <td>${author.total_votes}</td>
                        `;
                        authorsTableBody.appendChild(row);
                    });

                    // Hide loading overlay once data is loaded
                    document.getElementById('loadingOverlay').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById('loadingOverlay').style.display = 'none';
                });
        }

        // Call the function to load data when page is loaded
        document.addEventListener('DOMContentLoaded', loadTopAuthors);
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
