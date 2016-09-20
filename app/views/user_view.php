<h1>Добро пожаловать!</h1>
<?php foreach ($data as $row): ?>
    <div class="col-md-4">
        <h2><?=$row['login']?></h2>
        <p><?=$row['email']?></p>
    </div>
<?php endforeach; ?>