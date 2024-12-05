<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Edit Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <img id="modalProductImg" src="" alt="" class="img-fluid d-block mx-auto">
                    </div>
                    <div class="mb-3">
                        <label for="modalProductImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="modalProductImage" name="product_image">
                    </div>
                    <input type="hidden" id="modalProductId" name="product_id" value="">
                    <div class="mb-3">
                        <label for="modalProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="modalProductName" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalProductPrice" class="form-label">Product Price</label>
                        <input type="number" step="0.01" class="form-control" id="modalProductPrice" name="product_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalProductDesc" class="form-label">Product Description</label>
                        <textarea class="form-control" id="modalProductDesc" name="product_desc" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>