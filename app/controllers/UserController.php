<?php
class UserController extends Controller
{

    private $wishlistService;
    private $cartService;
    private $orderService;
    private $cartitems = [];
    public function __construct()
    {
        // Check if user is not logged in
        if (!isLoggedIn()) {
            redirect('pages/login'); // Redirect to home or another page if logged in
        }
        $this->wishlistService = new WishlistService();
        $this->cartService = new CartService();
        $this->orderService = new OrderService;

        // Fetch cart items for the logged-in user
        $this->cartitems = $this->cartService->getCartItemsByUserId($_SESSION['sessionData']['userId']);
    }


    // User Dashboard
    public function dashboard()
    {
        $data = [
            'title' => 'Shop',
            'cartCount' => count($this->cartitems) // Use count() to get the number of items
        ];


        $this->view('user/dashboard', $data);
    }

    // Add To Wishlist
    public function addToWishlist($productId)
    {
        // Check Post Request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flashMessage('errorMessage', 'Something went wrong!');
            redirect('productController/index');
            return;
        }
        $wishlist = new Wishlist;
        $wishlist->setUserId($_SESSION['sessionData']['userId']);
        $wishlist->setProductId($productId);
        if ($this->wishlistService->addWishlist($wishlist)) {
            flashMessage('successMessage', 'Product added to your wishlist!');
            redirect('productController/index'); // Redirect to wishlist page
        } else {
            // If product is already in the wishlist
            flashErrorMessage('errorMessage', 'Product is already in your wishlist!');
            redirect('productController/index'); // Redirect to wishlist page
        }
    }

    // Show wishlist
    public function showWishlist()
    {

        $wishlist = new Wishlist;
        $wishlist->setUserId($_SESSION['sessionData']['userId']);
        $wishlistItems = $this->wishlistService->getWishlistByUserId($wishlist);
        $data = [
            'wishlist' => $wishlistItems,
            'cartCount' => count($this->cartitems) // Use count() to get the number of items
        ];
        $this->view('user/wishlist', $data);
    }

    // Delete wishlist Item
    public function delete($productId)
    {
        // check for post request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            flashErrorMessage('errorMessage', '');
            redirect('userController/showWishlist');
        }
        // Proccess
        $wishlist = new Wishlist;
        $wishlist->setUserId($_SESSION['sessionData']['userId']);
        $wishlist->setProductId($productId);
        echo $wishlist->getUserId();
        echo $wishlist->getProductId();
        if ($this->wishlistService->deleteWishlistItem($wishlist)) {
            flashMessage('successMessage', 'Product deleted successfully');
            redirect('userController/showWishlist');
            return;
        }

        flashErrorMessage('errorMessage', 'Product not removed from wishlist');
        redirect('userController/showWishlist');
    }

    // Cart Handler
    public function myCart()
    {
        // Get the logged-in user ID from the session
        $userId = $_SESSION['sessionData']['userId'];

        // Fetch the cart items for the user
        $cartItems = $this->cartService->getCartItemsByUserId($userId);

        // Prepare data to pass to the view
        $data = [
            'title' => 'My Cart',
            'cartItems' => $cartItems,
            'cartCount' => count($this->cartitems) // Use count() to get the number of items
        ];

        // Load the cart view with the data
        $this->view('user/cart', $data);
    }

    public function order()
    {
        // Get the logged-in user ID from the session
        $userId = $_SESSION['sessionData']['userId'];

        // Fetch order items for the user
        $orderItems = $this->orderService->getOrderItemsByUserId($userId);

        // Prepare data to pass to the view
        $data = [
            'title' => 'My Orders',
            'orderItems' => $orderItems,
            'cartCount' => count($this->cartitems) // Use count() to get the number of items
        ];

        // Load the order view with the data
        $this->view('user/order', $data);
    }


    public function checkout($userId)
    {
        $orderService = new OrderService();
        $paymentIntent = $orderService->processCheckout($userId);

        if ($paymentIntent) {
            // Return the client secret to the frontend
            return json_encode(['clientSecret' => $paymentIntent->client_secret]);
        } else {
            // Handle the error, show an error message, etc.
            http_response_code(500);
            return json_encode(['error' => 'Checkout failed']);
        }
    }

    public function profile()
    {
        $data = [
            'cartCount' => count($this->cartitems) // Use count() to get the number of items
        ];
        $this->view('user/profile', $data);
    }
}
