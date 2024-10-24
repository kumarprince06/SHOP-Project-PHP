<?php require APPROOT . '/views/includes/header.php'; ?>

<h1>Product Details</h1>

<?php flashMessage('productMessage'); ?>

<!-- Display product details -->
<div>
    <h2><?php echo $data['product']->product_name; ?></h2>
    <p><strong>Brand:</strong> <?php echo $data['product']->brand; ?></p>
    <p><strong>Original Price:</strong> ₹<?php echo $data['product']->original_price; ?></p>
    <p><strong>Selling Price:</strong> ₹<?php echo $data['product']->selling_price; ?></p>
</div>
<a href="<?php echo URLROOT; ?>/products/index"><button>Go back</button></a>

<?php require APPROOT . '/views/includes/footer.php'; ?>