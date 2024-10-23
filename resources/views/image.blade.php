<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bem-vindo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="login-page">
    <div class="form">
        <form class="register-form">
            <img src="{{ asset('images/imjp-logo.png') }}" alt="IMJP Logo" style="max-width: 100%; height: auto;">
            <input type="text" placeholder="nome"/>
            <input type="text" placeholder="telefone"/>
            <input type="text" placeholder="email"/>
            <input type="password" placeholder="senha"/>
            <button>Criar</button>
            <p class="message">Já registrado? <a href="#">Faça login</a></p>
        </form>
        <form class="login-form">
            <img src="{{ asset('images/imjp-logo.png') }}" alt="IMJP Logo" style="max-width: 100%; height: auto;">
            <input type="text" placeholder="usuário"/>
            <input type="password" placeholder="senha"/>
            <button>login</button>
            <p class="message">Não registrado? <a href="#">Crie uma conta</a></p>
        </form>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
