<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Finding figures</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    @vite(['resources/css/file-input.css', 'resources/js/file-input.js'])
</head>

<body>
    <form id="upload-container" method="POST" action="send.php">
        <img id="upload-image" src="https://habrastorage.org/webt/dr/qg/cs/drqgcsoh1mosho2swyk3kk_mtwi.png">
        <div>
            <input id="file-input" type="file" name="file" multiple>
            <label for="file-input">Select a file</label>
            <span>or drag it here</span>
        </div>
    </form>

</body>

</html>
