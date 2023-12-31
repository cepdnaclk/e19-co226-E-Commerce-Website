<!-- New Phones -->
<?php
shuffle($product_shuffle);

// request method post
/*if($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['new_product_submit'])){
        // call method addToCart
        $Cart->addToCart($_SESSION['CustomerID'], $_POST['ProductID']);
    }
}*/
?>
<section id="new-phones">
    <div class="container">
        <h4 class="font-rubik font-size-20">New Products</h4>
        <hr>

        <!-- owl carousel -->
        <div class="owl-carousel owl-theme">
            <?php foreach ($product_shuffle as $item) { ?>
                <div class="item py-2 bg-light">
                    <div class="product font-rale">
                        <a href="<?php printf('%s?ProductID=%s', 'product.php',  $item['ProductID']); ?>"><img src="<?php echo $item['ProductImage'] ?? "./assets/products/1.png"; ?>" alt="product1" class="img-fluid" style="max-width: 200px; height: 200px;"></a>
                        <div class="text-center">
                            <h6><?php echo  $item['ProductName'] ?? "Unknown";  ?></h6>
                            <!--<div class="rating text-warning font-size-12">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="far fa-star"></i></span>
                            </div>-->
                            <div class="price py-2">
                                <span>$<?php echo $item['ProductPrice'] ?? '0' ; ?></span>
                            </div>
                            <form method="post">
                                <input type="hidden" name="item_id" value="<?php echo $item['ProductID'] ?? '1'; ?>">
                                <input type="hidden" name="user_id" value="<?php echo 1; ?>">
                                <button type="button" onclick="window.location.href='<?php printf('product.php?ProductID=%s', $item['ProductID']); ?>'" class="btn btn-warning font-size-12">View</button>

                                </form>
                        </div>
                    </div>
                </div>
            <?php } // closing foreach function ?>
        </div>
        <!-- !owl carousel -->

    </div>
</section>
<!-- !New Phones -->
