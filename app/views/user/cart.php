<?php require APPROOT . '/views/includes/header.php'; ?>

<h1>My Cart</h1>
<?php echo flashMessage('successMessage'); ?>
<?php echo flashErrorMessage('errorMessage'); ?>

<a href="<?php echo URLROOT; ?>"><button>Home</button></a>
<a href="<?php echo URLROOT; ?>/userController/dashboard"><button>Dashboard</button></a>

<?php if (empty($data['cartItems'])): ?>
    <p>Your cart is currently empty.</p>
    <a href="<?php echo URLROOT; ?>/productController/index">
        <button>Explore Products</button>
    </a>
<?php else: ?>
    <table style="width:100%; text-align:center; margin-top:5px;">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalAmount = 0;
            foreach ($data['cartItems'] as $item):
                $totalAmount += $item->total_price;
            ?>
                <tr>
                    <td><?php echo $item->name; ?></td>
                    <td><?php echo $item->brand; ?></td>
                    <td>Rs <?php echo $item->selling_price; ?></td>
                    <td>
                        <form action="<?php echo URLROOT ?>/cartController/decreaseCartItemQuantity/<?php echo $item->productId ?>" method="POST" style="display:inline;">
                            <button type="submit">-</button>
                        </form>
                        <?php echo $item->quantity; ?>
                        <form action="<?php echo URLROOT ?>/cartController/increaseCartItemQuantity/<?php echo $item->productId ?>" method="POST" style="display:inline;">
                            <button type="submit">+</button>
                        </form>
                    </td>
                    <td>Rs <?php echo $item->total_price; ?></td>
                    <td>
                        <form action="<?php echo URLROOT ?>/cartController/delete/<?php echo $item->productId ?>" method="POST" style="display:inline;">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (!empty($data['cartItems'])): ?>
        <h3>Total Amount: Rs <?php echo $totalAmount; ?></h3>

        <!-- Checkout Button -->
        <form action="<?php echo URLROOT ?>/checkoutController/start" method="POST">
            <button type="submit">Checkout</button>
        </form>

    <?php endif; ?>
<?php endif; ?>



<?php require APPROOT . '/views/includes/footer.php'; ?>