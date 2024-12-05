
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" action="" method="POST">

                    <div class="mb-3">
                        <label for="addProductImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="addProductImage" name="product_image" required>
                    </div>
                    <div class="mb-3">
                        <label for="addProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="addProductName" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="addProductPrice" class="form-label">Product Price</label>
                        <input type="number" step="0.01" class="form-control" id="addProductPrice" name="product_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="addProductDesc" class="form-label">Product Description</label>
                        <textarea class="form-control" id="addProductDesc" name="product_desc" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="add">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
