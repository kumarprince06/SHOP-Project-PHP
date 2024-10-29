<?php

class Products extends Controller
{
    private $digitalProductModel;
    private $physicalProductModel;
    private $productModel;
    private $wishlistModel;
    private $categoryModel;
    public function __construct()
    {
        if (!isLoggedIn()) {

            redirect('pages/login');
        }
        $this->productModel = $this->model('Product');
        $this->physicalProductModel = $this->model('PhysicalProduct');
        $this->digitalProductModel = $this->model('DigitalProduct');
        $this->wishlistModel = $this->model('Wishlist');
        $this->categoryModel = $this->model('Category');
    }

    // Index Page Handler
    public function index()
    {
        $products = $this->productModel->getAllProducts();
        $data = [
            'title' => 'Shop',
            'products' => $products
        ];

        // Load Product Index Page
        $this->view('products/index', $data);
    }

    // Add Product Handler
    public function add()
    {
        // Check POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Process form
            // Initialize form data
            $data = [
                'title' => 'Shop',
                'productName' => trim($_POST['productName']),
                'productBrand' => trim($_POST['productBrand']),
                'originalPrice' => trim($_POST['originalPrice']),
                'sellingPrice' => trim($_POST['sellingPrice']),
                'productType' => trim($_POST['productType']),
                'categoryId' => trim($_POST['categoryId']),
                'productNameError' => '',
                'productBrandError' => '',
                'originalPriceError' => '',
                'sellingPriceError' => '',
                'productTypeError' => '',
                'categoryIdError' => ''
            ];

            // Validate Product Name
            if (empty($data['productName'])) {
                $data['productNameError'] = "Product name is required!";
            }

            // Validate Product Brand
            if (empty($data['productBrand'])) {
                $data['productBrandError'] = "Brand name is required!";
            } elseif (!preg_match("/^[a-zA-Z]+$/", $data['productBrand'])) {
                $data['productBrandError'] = "Only alphabets are allowed!";
            }

            // Validate Original Price
            if (empty($data['originalPrice'])) {
                $data['originalPriceError'] = 'Original price is required!';
            } elseif (!preg_match("/^[0-9]+$/", $data['originalPrice'])) {
                $data['originalPriceError'] = 'Only numbers are allowed!';
            }

            // Validate Selling Price
            if (empty($data['sellingPrice'])) {
                $data['sellingPriceError'] = 'Selling price is required!';
            } elseif (!preg_match("/^[0-9]+$/", $data['sellingPrice'])) {
                $data['sellingPriceError'] = 'Only numbers are allowed!';
            }

            // Validate Product Type
            if (empty($data['productType'])) {
                $data['productTypeError'] = 'Select the product type!';
            }

            // Validate Category
            if (empty($data['categoryId'])) {
                $data['categoryIdError'] = 'Select a category!';
            }

            // Check for no errors
            if (empty($data['productNameError']) && empty($data['productBrandError']) && empty($data['originalPriceError']) && empty($data['sellingPriceError']) && empty($data['productTypeError']) && empty($data['categoryIdError'])) {
                // Validated

                // Add categoryId to data passed to model
                $lastInsertedId = $data['productType'] == 'Physical' ? $this->physicalProductModel->addPhysicalProduct($data) : $this->digitalProductModel->addDigitalProduct($data);

                if ($lastInsertedId) {
                    flashMessage('productMessage', 'Product added successfully');
                    // Redirect to the show page with the last inserted product ID
                    redirect('products/show/' . $lastInsertedId);
                } else {
                    die('Something went wrong..!');
                }
            } else {
                // Load view with errors
                $category = $this->categoryModel->getAllCategory();
                $data['categories'] = $category;

                $this->view('products/add', $data);
            }
        } else {
            // Initial empty form
            $category = $this->categoryModel->getAllCategory();
            $data = [
                'title' => 'Shop',
                'productName' => '',
                'productBrand' => '',
                'originalPrice' => '',
                'sellingPrice' => '',
                'productType' => '',
                'categoryId' => '',
                'productNameError' => '',
                'productBrandError' => '',
                'originalPriceError' => '',
                'sellingPriceError' => '',
                'productTypeError' => '',
                'categoryIdError' => '',
                'categories' => $category
            ];

            $this->view('products/add', $data);
        }
    }


    // View Product Handler
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        $data = ['title' => 'Shop', 'product' => $product];
        $this->view('products/show', $data);
    }

    // Edit / Update Product Handler
    public function edit($id)
    {
        // Check Post Request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Process form
            // Initialize form data
            $data = [
                'title' => 'Shop',
                'id' => $id,
                'productName' => trim($_POST['productName']),
                'productBrand' => trim($_POST['productBrand']),
                'originalPrice' => trim($_POST['originalPrice']),
                'sellingPrice' => trim($_POST['sellingPrice']),
                'productType' => trim($_POST['productType']),
                'categoryId' => trim($_POST['categoryId']),
                'productNameError' => '',
                'productBrandError' => '',
                'originalPriceError' => '',
                'sellingPriceError' => '',
                'productTypeError' => '',
                'categoryError' => '',
            ];

            // Validate Product Name
            if (empty($data['productName'])) {
                $data['productNameError'] = "Product name is required!";
            }

            // Validate Product Brand
            if (empty($data['productBrand'])) {
                $data['productBrandError'] = "Brand name is required!";
            } else if (!preg_match("/^[a-zA-Z]+$/", $data['productBrand'])) {
                $data['productBrandError'] = "Only alphabets are allowed!";
            }

            // Validate Product Original Price
            if (empty($data['originalPrice'])) {
                $data['originalPriceError'] = 'Original price is required!';
            } else if (!preg_match("/^[0-9]+$/", $data['originalPrice'])) {
                $data['originalPriceError'] = 'Only numbers are allowed!';
            }

            // Validate Product Selling Price
            if (empty($data['sellingPrice'])) {
                $data['sellingPriceError'] = 'Selling price is required!';
            } else if (!preg_match("/^[0-9]+$/", $data['sellingPrice'])) {
                $data['sellingPriceError'] = 'Only numbers are allowed!';
            }

            // Validate Product Type
            if (empty($data['productType'])) {
                $data['productTypeError'] = 'Select the product type!';
            }

            // Validate Category
            if (empty($data['categoryId'])) {
                $data['categoryIdError'] = 'Select the category!!';
            }

            // Check for No Error
            if (empty($data['productNameError']) && empty($data['productBrandError']) && empty($data['originalPriceError']) && empty($data['sellingPriceError'])) {
                // Validated
                if ($this->productModel->updateProduct($data)) {
                    flashMessage(
                        'productMessage',
                        'Product added successfully'
                    );
                    // Redirect to the show page with the last inserted product ID
                    redirect('products/index');
                } else {
                    die('Something went wrong..!');
                }
            } else {
                // Load View with errors
                $this->view('products/edit', $data);
            }
        } else {
            // Fetch existing post
            $product = $this->productModel->getProductById($id);
            // var_dump($product);
            // // Check for owner
            // if ($product->role != $_SESSION['role']) {
            //     redirect('posts');
            // }
            // Initial empty form
            $category = $this->categoryModel->getAllCategory();
            $data = [
                'title' => 'Shop',
                'id' => $product->id,
                'productName' => $product->product_name,
                'productBrand' => $product->brand,
                'originalPrice' => $product->original_price,
                'sellingPrice' =>  $product->selling_price,
                'productType' => $product->product_type,
                'categoryId' => $product->categoryId,
                'productNameError' => '',
                'productBrandError' => '',
                'originalPriceError' => '',
                'sellingPriceError' => '',
                'productTypeError' => '',
                'category' => $category
            ];

            $this->view('products/edit', $data);
        }
    }

    // Delete Product Handler
    public function delete($id)
    {
        // check for post request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Proccess
            // Fetch existing post
            // $post = $this->productModel->getPostById($id);
            // // Check for owner
            // if ($post->userId != $_SESSION['user_id']) {
            //     redirect('posts');
            // }

            if ($this->productModel->deletePostById($id)) {
                flashMessage('productMessage', 'Product deleted successfully');
                redirect('products');
            }
        } else {
            // Redirect to post
            redirect('products');
        }
    }
}
