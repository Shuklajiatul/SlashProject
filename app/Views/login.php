<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            margin: 0;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        .form-container p {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="/login" method="post">
            <?= csrf_field() ?>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
            <input type="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="/register">Register</a></p>
        </form>
    </div>
</body>

</html>

