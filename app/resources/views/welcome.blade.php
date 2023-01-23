<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Finding figures</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    @vite(['resources/css/file-input.css', 'resources/js/file-input.js'])
</head>

<body>
    <form id="upload-container" method="POST" action="{{ route('send-file') }}" enctype="multipart/form-data">
        @csrf
        <img id="upload-image" src="https://habrastorage.org/webt/dr/qg/cs/drqgcsoh1mosho2swyk3kk_mtwi.png">
        <div>
            <input type="file" name="file" id="file-input">
            <label for="file-input">Select a file</label>
            <span>or drag it here</span>
        </div>
        <button hidden id="upload-button" type="submit">Upload</button>
    </form>

</body>

</html>