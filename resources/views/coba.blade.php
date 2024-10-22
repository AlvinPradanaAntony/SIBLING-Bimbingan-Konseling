<!-- resources/views/users/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Users Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img-table {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .modal-preview-img {
            max-width: 150px;
            height: auto;
            cursor: pointer; /* Menambahkan cursor pointer untuk indikasi bisa diklik */
        }

        #fullscreenPreview {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        #fullscreenPreview img {
            max-width: 90%;
            max-height: 90vh;
        }

        #fullscreenPreview .close-preview {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 30px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Users Data</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Profile Picture</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Dummy data
                        $users = [
                            [
                                'id' => 1,
                                'profile_picture' => 'https://via.placeholder.com/150',
                                'name' => 'John Doe',
                                'email' => 'john@example.com',
                                'gender' => 'Male'
                            ],
                            [
                                'id' => 2,
                                'profile_picture' => 'https://via.placeholder.com/150',
                                'name' => 'Jane Smith',
                                'email' => 'jane@example.com',
                                'gender' => 'Female'
                            ],
                            // Add more dummy data as needed
                        ];
                    @endphp

                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img src="{{ $user['profile_picture'] }}" 
                                     class="profile-img-table"
                                     onclick="showFullscreen('{{ $user['profile_picture'] }}')"
                                     alt="Profile picture">
                            </td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['gender'] }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" 
                                        onclick="openEditModal({{ json_encode($user) }})">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label for="profilePreview" class="form-label">Current Profile Picture</label>
                            <div class="text-center">
                                <img id="profilePreview" 
                                     src="" 
                                     class="modal-preview-img mb-2" 
                                     onclick="showFullscreen(this.src)" 
                                     title="Click to view fullscreen">
                            </div>
                            <input type="file" class="form-control" id="newProfilePicture" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Image Preview -->
    <div id="fullscreenPreview" onclick="closeFullscreen()">
        <span class="close-preview">&times;</span>
        <img src="" alt="Fullscreen preview">
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize modal
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        
        // Open edit modal and populate with user data
        function openEditModal(user) {
            document.getElementById('userId').value = user.id;
            document.getElementById('profilePreview').src = user.profile_picture;
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            document.getElementById('gender').value = user.gender;
            editModal.show();
        }

        // Show fullscreen image preview
        function showFullscreen(imgSrc) {
            const preview = document.getElementById('fullscreenPreview');
            preview.querySelector('img').src = imgSrc;
            preview.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Close fullscreen preview
        function closeFullscreen() {
            document.getElementById('fullscreenPreview').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Handle image upload preview
        document.getElementById('newProfilePicture').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('profilePreview');
                    previewImg.src = e.target.result;
                    // Memastikan event onclick masih berfungsi untuk gambar yang baru diupload
                    previewImg.onclick = () => showFullscreen(e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Save changes (implement your save logic here)
        function saveChanges() {
            // Get form data
            const formData = {
                id: document.getElementById('userId').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                gender: document.getElementById('gender').value,
                // Handle file upload separately if needed
            };

            // Add your save logic here
            console.log('Saving changes:', formData);
            
            // Close modal after save
            editModal.hide();
        }
    </script>
</body>
</html>