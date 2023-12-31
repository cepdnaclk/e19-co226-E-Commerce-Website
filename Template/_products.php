<!--   product  -->
<?php
    $item_id = $_GET['ProductID'] ?? 1;
    $item =null;
    foreach ($product->getData() as $itr) {
        if ($itr['ProductID'] == $item_id) {
            $item =  $itr;
        }
    }




// request method post

   if($_SERVER['REQUEST_METHOD'] == "POST"){
       if (isset($_POST['cart_submit'])){
           // call method addToCart
           //Check the session
          if ( isset($_SESSION['CustomerID'])){
              if (session_status() === PHP_SESSION_ACTIVE) {

              } else {
                  session_start();
              }
              //find total price
              $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
              $totalPrice = ($item['ProductPrice'] ?? 0) * $quantity;
              $Cart->addToCart($_SESSION['CustomerID'], $item['ProductID'],$_POST['quantity'],$totalPrice);
              header("Location: cart.php");
              exit();
          }else{
              header("Location: sign-in.php");
              exit();
          }

       }
   }
   //get Cart ID
   $CartID = 0;
   $resultArray=$product->getData('cart');
   foreach ($resultArray as $arr) {
       if(isset($_SESSION['CustomerID']) && $arr['CustomerID'] === $_SESSION['CustomerID']){
           $CartID = $arr['CartID'];
       }
   }

?>


<section id="product" class="py-3">
    <form method="post">
        <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="<?php echo $item['ProductImage'] ?? "./assets/products/1.png" ?>" alt="product" class="img-fluid">
                <div class="form-row pt-4 font-size-16 font-baloo">
                    <!--<div class="col">
                        <button type="submit" class="btn btn-danger form-control">Proceed to Buy</button>
                    </div>-->
                    <div class="col">
                        <?php
                        $productIDsInCart = $product->getProductId($CartID, 'cart_items');

                        $isInCart = false;

                        foreach ($productIDsInCart as $productID) {
                            if ($productID['ProductID'] === $item['ProductID']) {
                                $isInCart = true;
                                break;
                            }
                        }

                        if ($isInCart) {
                            echo '<button type="submit" class="btn btn-success font-size-16 form-control">In the Cart</button>';
                        } else {
                            echo '<button type="submit" name="cart_submit" class="btn btn-warning font-size-16 form-control">Add to Cart</button>';

                        }
                        ?>


                    </div>
                </div>
            </div>
            <div class="col-sm-6 py-5">
                <h5 class="font-baloo font-size-20"><?php echo $item['ProductName'] ?? "Unknown"; ?></h5>
                <hr class="m-0">

                <!---    product price       -->
                <table class="my-3">
                    <tr class="font-rale font-size-14">
                        <td>Deal Price:</td>
                        <td class="font-size-20 text-danger">$<span><?php echo $item['ProductPrice'] ?? 0; ?></span><small class="text-dark font-size-12">&nbsp;&nbsp;Inclusive of all taxes</small></td>
                    </tr>
                </table>
                <!---    !product price       -->

                <!--    #policy -->
                <div id="policy">
                    <div class="d-flex">
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-retweet border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12">10 Days <br> Replacement</a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-truck  border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12">Electro Mart <br>Deliverd</a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-check-double border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12">1 Year <br>Warranty</a>
                        </div>
                    </div>
                </div>
                <!--    !policy -->
                <hr>

                <!-- order-details -->
                <!--<div id="order-details" class="font-rale d-flex flex-column text-dark">
                    <small>Delivery by : Mar 29  - Apr 1</small>
                    <small>Sold by <a href="#">Daily Electronics </a>(4.5 out of 5 | 18,198 ratings)</small>
                    <small><i class="fas fa-map-marker-alt color-primary"></i>&nbsp;&nbsp;Deliver to Customer - 424201</small>
                </div>-->
                <!-- !order-details -->

                <div class="row">
                    <!--<div class="col-6">

                        <div class="color my-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-baloo">Color:</h6>
                                <div class="p-2 color-yellow-bg rounded-circle"><button class="btn font-size-14"></button></div>
                                <div class="p-2 color-primary-bg rounded-circle"><button class="btn font-size-14"></button></div>
                                <div class="p-2 color-second-bg rounded-circle"><button class="btn font-size-14"></button></div>
                            </div>
                        </div>

                    </div>-->
                    <div class="col-6">
                        <!-- product qty section -->
                        <div class="qty d-flex">
                            <h6 class="font-baloo">Qty</h6>
                            <div class="px-4 d-flex font-rale">
                                <?php $productQty = $product->getProduct($item['ProductID'])[0]['ProductQty']; ?>
                                <button class="qty-up border bg-light" data-id="pro1" onclick="changeQuantity('pro1', 'up', <?php echo $productQty; ?>); return false;"><i class="fas fa-angle-up"></i></button>
                                <input type="text" data-id="pro1" name="quantity" class="qty_input border px-2 w-50 bg-light" value="1" placeholder="1">
                                <button data-id="pro1" class="qty-down border bg-light" onclick="changeQuantity('pro1', 'down'); return false;"><i class="fas fa-angle-down"></i></button>
                            </div>
                        </div>
                        <script>
                            function changeQuantity(productId, action, maxQuantity) {
                                const inputElement = document.querySelector(`input[data-id="${productId}"]`);
                                let quantity = parseInt(inputElement.value);

                                if (action === 'up' && quantity < maxQuantity) {
                                    quantity++;
                                } else if (action === 'down' && quantity > 1) {
                                    quantity--;
                                }

                                inputElement.value = quantity;
                            }
                        </script>

                        <!-- !product qty section -->
                    </div>
                </div>

                <!-- size -->
                <!--<div class="size my-3">
                    <h6 class="font-baloo">Size :</h6>
                    <div class="d-flex justify-content-between w-75">
                        <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">4GB RAM</button>
                        </div>
                        <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">6GB RAM</button>
                        </div>
                        <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">8GB RAM</button>
                        </div>
                    </div>
                </div>-->
                <!-- !size -->


            </div>

            <div class="col-12" style="margin-top:50px;">
                <h6 class="font-rubik">Product Description</h6>
                <hr>
                <p class="font-rale font-size-14"><?php echo $item['ProductDetails'] ?? ""; ?></p>
            </div>
        </div>
    </div>
    </form>
</section>

<!--   !product  -->
<?php
/*        endif;
        endforeach;
*/?>
