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
    </form>
    <h1>Remove product</h1>
    <form action="/api/product/delete" method="POST" enctype="multipart/form-data">
        <label for="id">Product ID:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">Remove product</button>
    </form>
    <h1>Products</h1>
    <div class='list'>
        <?php
        use ProductHack\models\ProductModel;
        $productModel = new ProductModel();
        foreach($productModel->selectAll() as $value):
        ?>
        <div class='item'><?php echo var_dump($value) ?></div>
        <?php endforeach; ?>
    </div>

    <h1>Add images</h1>
    <form action="/api/product/create" method="POST" enctype="multipart/form-data">
        <label for="image">Price:</label>
        <input type="number" id="price" name="price" required step="0.01" min="0">

        <label for="image">Image:</label>
        <input type="file" id="image" name="image1" accept="image1/*">

        <button type="submit">Add product</button>
    </form>
    <h1>Images</h1>
    <div class='list'>
        <?php 
        use ProductHack\models\ImagesModel;
        $imagesModel = new ImagesModel();
        foreach($imagesModel->selectAll() as $value):
        ?>
        <div class='item'>
            <p>ID: <?php echo $value["id"] ?></p>
            <img alt='img' src='<?php echo $value["base64"] ?>'/>
        </div>
        <?php endforeach;?>
    </div>

</main>
