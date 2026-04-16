<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News API — documentação</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css" crossorigin="anonymous">
    <style>
        body { margin: 0; }
    </style>
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js" crossorigin="anonymous"></script>
<script>
    window.onload = () => {
        window.ui = SwaggerUIBundle({
            url: @json($specUrl),
            dom_id: '#swagger-ui',
        });
    };
</script>
</body>
</html>
