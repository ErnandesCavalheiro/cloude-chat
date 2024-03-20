<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Mensagem</title>
</head>
<body>
    <h1>Formulário de Mensagem</h1>

    <form action="/test" method="POST">
        @csrf
        <label for="message">Mensagem:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
