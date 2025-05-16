<?php
    use function App\Core\generateCsrfToken;
?>

<h2>Login</h2>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($rememberedEmail ?? '') ?>"  required>
    <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
    <input type="checkbox" name="remember" id="remember">
    <label for="remember">Remember me</label>
    <div>
        <button class="btn btn-success">Login</button>
        <a class="btn btn-primary" href="?url=register">Register</a>
    </div>
</form>