<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>Наш сайт</title>
    <link rel="stylesheet" href="/assets/template/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/template/css/bootstrap-theme.min.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

<nav class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Учим MVC</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">Главная</a></li>
                <li><a href="/about/">О сайте</a></li>
                <li><a href="/portfolio/">Портфолио</a></li>
                <li><a href="/contact/">Контакты</a></li>
            </ul>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <?php include 'app/views/'.$content_view;?>
    </div>
</div>

<div class="container">
    <hr>

    <footer>
        <p>© 2016 LoftSchool</p>
    </footer>
</div> <!-- /container -->

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="/assets/template/js/bootstrap.min.js"></script>
</body>
</html>