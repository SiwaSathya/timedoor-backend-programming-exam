<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Books</title>
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

        /* CSS untuk Scrollable Dropdown */
        #authorSelect, #bookSelect {
            max-height: 200px; /* Set tinggi maksimal */
            overflow-y: auto;  /* Menambahkan scroll vertikal jika pilihan lebih banyak */
        }

        /* Spinner Overlay */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            display: none; /* Hide by default */
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure spinner is on top of all content */
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1>Rate a Book</h1>

        <form id="ratingForm">
            <!-- Dropdown untuk memilih Author -->
            <div class="mb-3">
                <label for="authorSelect" class="form-label">Select Author</label>
                <select class="form-select" id="authorSelect" onchange="fetchBooks()" required>
                    <option value="">Select an Author</option>
                    <!-- Option will be populated by JavaScript -->
                </select>
            </div>

            <!-- Dropdown untuk memilih Book (disabled until author is selected) -->
            <div class="mb-3">
                <label for="bookSelect" class="form-label">Select Book</label>
                <select class="form-select" id="bookSelect" disabled required>
                    <option value="">Select a Book</option>
                    <!-- Option will be populated by JavaScript -->
                </select>
            </div>

            <!-- Input untuk Rating -->
            <div class="mb-3">
                <label for="ratingInput" class="form-label">Rating (1 to 10)</label>
                <select class="form-select" id="ratingInput" required>
                    <option value="">Select a Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="button" class="btn btn-primary" onclick="submitRating()">Submit</button>
        </form>
    </div>

    <!-- Loading Spinner Overlay -->
    <div id="loadingOverlay">
        <div class="spinner-border"></div> <!-- Spinner for loading -->
    </div>

    <script>
        // Function to fetch authors from API
        function fetchAuthors() {
            // Show loading spinner when fetching authors
            document.getElementById('loadingOverlay').style.display = 'flex';

            fetch('http://127.0.0.1:8000/api/get-all-author')
                .then(response => response.json())
                .then(data => {
                    console.log('Authors:', data.data);  // Log data to check its structure

                    const authorSelect = document.getElementById('authorSelect');
                    authorSelect.innerHTML = '<option value="">Select an Author</option>';  // Reset the options

                    // Loop through the data to create options
                    data.data.forEach(author => {
                        const option = document.createElement('option');
                        option.value = author.id; // Use id_author for value
                        option.textContent = author.name; // Use author_name for text
                        authorSelect.appendChild(option);
                    });

                    // Hide the loading spinner after authors are loaded
                    document.getElementById('loadingOverlay').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error fetching authors:', error);
                    document.getElementById('loadingOverlay').style.display = 'none';
                    alert('Failed to load authors');
                });
        }

        // Function to fetch books based on selected author
        function fetchBooks() {
            const authorId = document.getElementById('authorSelect').value;
            const bookSelect = document.getElementById('bookSelect');

            if (!authorId) {
                return; // Exit if no author is selected
            }

            // Show loading spinner while fetching books
            document.getElementById('loadingOverlay').style.display = 'flex';

            bookSelect.disabled = false;  // Enable the book select dropdown

            fetch(`http://127.0.0.1:8000/api/get-book-by-author/${authorId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Books:', data);  // Log books data to check its structure

                    // Clear previous options before adding new ones
                    bookSelect.innerHTML = '<option value="">Select a Book</option>';

                    // Check if the data is in the correct format and not empty
                    if (data && data.data && Array.isArray(data.data)) {
                        data.data.forEach(book => {
                            const option = document.createElement('option');
                            option.value = book.id; // Use the book ID
                            option.textContent = book.book_name; // Use the book name
                            bookSelect.appendChild(option);
                        });
                    } else {
                        console.error('Books data is not in the expected format:', data);
                    }

                    // Hide the loading spinner after books are loaded
                    document.getElementById('loadingOverlay').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error fetching books:', error);
                    document.getElementById('loadingOverlay').style.display = 'none';
                    alert('Failed to load books');
                });
        }

        // Function to submit the rating
        function submitRating() {
            const authorId = document.getElementById('authorSelect').value;
            const bookId = document.getElementById('bookSelect').value;
            const rating = document.getElementById('ratingInput').value;

            if (!authorId || !bookId || !rating) {
                alert('Please select an author, a book, and provide a rating.');
                return;
            }

            // Show loading spinner while submitting
            document.getElementById('loadingOverlay').style.display = 'flex';

            // Send POST request to submit the rating
            fetch('http://127.0.0.1:8000/api/rates', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    author_id: authorId,
                    book_id: bookId,
                    rating: rating,
                }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message); // Show success message
                document.getElementById('loadingOverlay').style.display = 'none'; // Hide loading spinner

                // Redirect to main page after successful submission
                window.location.href = '/'; // Redirect to main page (assuming it's the homepage)
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loadingOverlay').style.display = 'none'; // Hide loading spinner on error
            });
        }

        // Call fetchAuthors() to populate author dropdown when the page loads
        document.addEventListener('DOMContentLoaded', fetchAuthors);
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
