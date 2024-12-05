<header class="py-2 border-bottom bg-search">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-11 d-flex flex-wrap">
                <ul class="nav">
                    
                    
                </ul>
                <div class="col-9 col-md-7 col-xl-5 mx-auto">
                   <form method="GET" action="product.php">
                    <div class="input-group">
                        <input type="search " name="search" class="form-control border-end-0 border border rounded-pill z-1 "
                        values="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES) : '' ?>"
                        id="example-search-input" placeholder="Search for Products">
                        <span class="input-group-append">
                            <button class="btn btn-dark rounded-pill ms-5" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </span>
                    </div>
                   </form>     
                </div>
            </div>
        </div>
    </div>
</header>