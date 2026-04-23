<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Admin Login</h4>
                        <div class="alert alert-danger d-none" id="loginError"></div>
                        <form id="adminLoginForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-dark w-100" id="submitBtn">Login</button>
                        </form>
                        <p class="text-muted mt-3 mb-0 small">Seeded sample: admin@jlene.test / admin12345</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#adminLoginForm').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('#submitBtn');
                var $error = $('#loginError');
                $error.addClass('d-none').text('');
                $btn.prop('disabled', true).text('Logging in...');

                $.ajax({
                    url: "{{ route('admin.login.post') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        window.location.href = response.redirect;
                    },
                    error: function (xhr) {
                        var msg = 'Login failed.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var firstKey = Object.keys(xhr.responseJSON.errors)[0];
                            msg = xhr.responseJSON.errors[firstKey][0];
                        }
                        $error.removeClass('d-none').text(msg);
                    },
                    complete: function () {
                        $btn.prop('disabled', false).text('Login');
                    }
                });
            });
        });
    </script>
</body>
</html>
