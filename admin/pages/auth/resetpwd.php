<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">PROFIL PERUSAHAAN</h1>

    <!-- Profil Perusahaan Section -->
    <div class="card shadow mb-4">     

            <!-- Password Reset Form -->
                    <div class="card-header">
                        <i class="fas fa-key me-2"></i>Form Reset Password
                    </div>
                    <div class="card-body">
                        <form class="password-form" method="POST" action="proses_reset.php">
                            <div class="form-group">
                                <label class="form-label">Password Saat Ini</label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control" id="currentPassword" required>
                                    <span class="password-visibility" onclick="togglePassword('currentPassword')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control" id="newPassword" required>
                                    <span class="password-visibility" onclick="togglePassword('newPassword')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                <div class="password-strength">
                                    <div class="password-strength-bar" id="password-strength-bar"></div>
                                </div>
                                <div class="password-rules">
                                    <ul>
                                        <li id="rule-length">Minimal 8 karakter</li>
                                        <li id="rule-uppercase">Minimal 1 huruf besar</li>
                                        <li id="rule-number">Minimal 1 angka</li>
                                        <li id="rule-special">Minimal 1 karakter khusus</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control" id="confirmPassword" required>
                                    <span class="password-visibility" onclick="togglePassword('confirmPassword')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                <div class="form-text" id="password-match"></div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-redo me-2"></i>Reset Password
                                </button>
                            </div>
                        </form>
            <!-- Security Tips -->
            <div class="col-lg-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <i class="fas fa-shield-alt me-2"></i>Tips Keamanan Password
                    </div>
                    <div class="card-body">
                        <div class="security-tips">
                            <h5><i class="fas fa-lightbulb me-2"></i>Buat password yang kuat</h5>
                            <ul>
                                <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                                <li>Hindari informasi pribadi seperti nama atau tanggal lahir</li>
                                <li>Jangan gunakan password yang sama untuk beberapa akun</li>
                                <li>Ubah password secara berkala (setiap 3-6 bulan)</li>
                                <li>Pertimbangkan menggunakan frasa panjang yang mudah diingat</li>
                            </ul>
                        </div>
                        
                        <div class="mt-4">
                            <h5><i class="fas fa-history me-2"></i>Riwayat Password</h5>
                            <p>Anda dapat mengubah password setiap saat untuk meningkatkan keamanan akun Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Script -->
    <script>
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Password strength checker
        document.getElementById('newPassword').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength-bar');
            const rules = {
                length: document.getElementById('rule-length'),
                uppercase: document.getElementById('rule-uppercase'),
                number: document.getElementById('rule-number'),
                special: document.getElementById('rule-special')
            };
            
            let strength = 0;
            let color = '';
            
            // Reset rules
            for (const rule in rules) {
                rules[rule].classList.remove('valid');
            }
            
            // Check password length
            if (password.length >= 8) {
                strength += 25;
                rules.length.classList.add('valid');
            }
            
            // Check uppercase letters
            if (/[A-Z]/.test(password)) {
                strength += 25;
                rules.uppercase.classList.add('valid');
            }
            
            // Check numbers
            if (/[0-9]/.test(password)) {
                strength += 25;
                rules.number.classList.add('valid');
            }
            
            // Check special characters
            if (/[^A-Za-z0-9]/.test(password)) {
                strength += 25;
                rules.special.classList.add('valid');
            }
            
            // Update strength bar
            strengthBar.style.width = strength + '%';
            
            // Set color based on strength
            if (strength < 50) {
                color = '#dc3545'; // Red
            } else if (strength < 75) {
                color = '#ffc107'; // Yellow
            } else {
                color = '#28a745'; // Green
            }
            
            strengthBar.style.backgroundColor = color;
        });
        
        // Password match checker
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = this.value;
            const matchIndicator = document.getElementById('password-match');
            
            if (confirmPassword === '') {
                matchIndicator.textContent = '';
                matchIndicator.className = 'form-text';
            } else if (newPassword === confirmPassword) {
                matchIndicator.textContent = 'Password cocok';
                matchIndicator.className = 'form-text text-success';
            } else {
                matchIndicator.textContent = 'Password tidak cocok';
                matchIndicator.className = 'form-text text-danger';
            }
        });
        
        // Form submission
        document.querySelector('.password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Simple validation
            if (!currentPassword) {
                alert('Harap masukkan password saat ini');
                return;
            }
            
            if (!newPassword) {
                alert('Harap masukkan password baru');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                alert('Password baru dan konfirmasi password tidak cocok');
                return;
            }
            
            // Simulate form submission
            alert('Password berhasil diubah!');
            
            // In a real application, you would submit the form to the server here
            // this.submit();
        });
    </script>