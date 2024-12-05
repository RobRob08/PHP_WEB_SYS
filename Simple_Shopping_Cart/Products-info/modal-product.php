<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="modalProductImg" class="img-fluid" src="" alt="">
                    </div>
                    <div class="col-md-6">
                        <h1 id="modalProductName" class="display-5"></h1>
                        <h5 id="modalProductPrice"></h5>
                        <p id="modalProductDesc"></p>

                        <?php if (isset($_SESSION['account_email'])) { ?>
                            <form method="POST" action="">
                                <button type="submit" name="add_to_cart" class="btn btn-lg add-to-cart-btn btn-block mt-2 mb-10 px-5 py-0 rounded-pill text-light" value="" id="modalProductAddToCart" title="Add to Cart">Add to <i class="bi bi-cart-fill"></i></button>
                            </form>
                        <?php } else { ?>
                            <p>Please log in to add to cart.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.category-card[data-bs-toggle="modal"]').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();

        const productId = this.getAttribute('data-product-id');
        const productName = this.getAttribute('data-product-name');
        const productPrice = this.getAttribute('data-product-price');
        const productImage = this.getAttribute('data-product-image');
        const productDesc = this.getAttribute('data-product-desc');


        document.getElementById('modalProductName').innerText = productName;
        document.getElementById('modalProductPrice').innerText = '$' + parseFloat(productPrice).toFixed(2);
        document.getElementById('modalProductDesc').innerText = productDesc;
        document.getElementById('modalProductImg').src = 'assets/images/' + productImage;


        const addToCartButton = document.getElementById('modalProductAddToCart');
        addToCartButton.value = productId;
    });
});

</script>