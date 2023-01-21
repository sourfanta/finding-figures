<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Пошук фігур</title>
    <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
    @vite(['resources/css/file-input.css'])
</head>

<body>
    <form id="upload-container" method="POST" action="send.php">
        <img id="upload-image" src="https://cdn-icons-png.flaticon.com/512/2716/2716054.png">
        <div>
            <input id="file-input" type="file" name="file" multiple>
            <label for="file-input">Виберіть файл</label>
            <span>або перенесіть його сюди</span>
        </div>
    </form>
</body>

</html>
