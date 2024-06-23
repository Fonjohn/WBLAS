<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LED Matrix Display</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <div class="container">
        <h1>LED Matrix Display</h1>
        <form>
            <input type="text" id="char" name="char" maxlength="1" placeholder="A-Z, 0-9" required>
            <input type="submit" value="Submit">
        </form>
        <table id="led-matrix"></table>
    </div>
    <script src="./script.js"></script>
</body>
</html>
