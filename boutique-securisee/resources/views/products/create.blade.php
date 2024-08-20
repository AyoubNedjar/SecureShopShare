<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Product</title>
</head>
<body>
    <h1>Create a New Product</h1>
    <form action="#">
        <label for="name">Product Name:</label><br>
        <input type="text" id="name" name="name"><br><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price"><br><br>
        <input type="submit" value="Create">
    </form>
    <a href="/products">Back to Product List</a>
</body>
</html>
