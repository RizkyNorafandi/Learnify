<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-left {
            background: linear-gradient(135deg, #005a7c, #087e96);
            color: white;
            text-align: center;
            padding: 40px;
        }

        .login-right {
            padding: 40px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-login {
            background-color: #005a7c;
            color: white;
        }

        .btn-login:hover {
            background-color: #087e96;
        }

        .forgot-password {
            color: #087e96;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="login-container d-flex">
        <!-- Left Side -->
        <div class="login-left col-md-6 d-flex flex-column justify-content-center align-items-center">
            <h1>LEARNIFY</h1>
            <p>Online Courses</p>
        </div>

        <!-- Right Side -->
        <div class="login-right col-md-6">
            <h3 class="mb-3">Login</h3>
            <p>Sign in to your account</p>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form id="loginForm">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button type="submit" class="btn btn-login w-100" id="btnLogin">Login</button>
            </form>
            <div id="errorMessage" class="text-danger mt-3"></div>

            <div class="text-center mt-3">
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('btnLogin').addEventListener('click', async () => {
            const form = document.getElementById('loginForm');
            const formData = new FormData(form);

            const response = await fetch('http://localhost/api/auth/login', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            if (response.ok) {
                alert('Login successful!');
                console.log(result); // Log token for testing
                // Redirect to dashboard or another page
                window.location.href = '/dashboard';
            } else {
                document.getElementById('errorMessage').innerText = result.message;
            }
        });
    </script>

</body>

</html>