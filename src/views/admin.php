<main>
    <h1>Add New Product</h1>
    <form action="/api/product/create" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required maxlength="150">

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required step="0.01" min="0">

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required min="0" value="0">

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit">Add product</button>
        <h2 class='messages'><?php echo var_dump($model);?></h2>
    </form>
    <img id='preview' alt='preview'/>
</main>
