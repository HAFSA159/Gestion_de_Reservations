<?php
session_start();
include 'partials.php';
include '../connection.php';
include '../classes/Activity.php';
include '../classes/Reservation.php';
include '../classes/Cart.php';

$cartItems = [];

if (isset($_SESSION['user_id'])) {
    $cart = new Cart($_SESSION['user_id'], $db);
    $cartItems = $cart->getUserCartItems($_SESSION['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_item_id'])) {
    $cart = new Cart($_SESSION['user_id'], $db);
    $cart_item_id = $_POST['cart_item_id'];
    $cart->deleteCartItem($cart_item_id);
    header("Location: cart.php");
    exit();
}

?>

<style>
    @layer utilities {
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    }
</style>


<body>
<header>
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <div class="hidden w-full text-gray-600 md:flex md:items-center">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M16.2721 10.2721C16.2721 12.4813 14.4813 14.2721 12.2721 14.2721C10.063 14.2721 8.27214 12.4813 8.27214 10.2721C8.27214 8.06298 10.063 6.27212 12.2721 6.27212C14.4813 6.27212 16.2721 8.06298 16.2721 10.2721ZM14.2721 10.2721C14.2721 11.3767 13.3767 12.2721 12.2721 12.2721C11.1676 12.2721 10.2721 11.3767 10.2721 10.2721C10.2721 9.16755 11.1676 8.27212 12.2721 8.27212C13.3767 8.27212 14.2721 9.16755 14.2721 10.2721Z"
                          fill="currentColor"/>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M5.79417 16.5183C2.19424 13.0909 2.05438 7.39409 5.48178 3.79417C8.90918 0.194243 14.6059 0.054383 18.2059 3.48178C21.8058 6.90918 21.9457 12.6059 18.5183 16.2059L12.3124 22.7241L5.79417 16.5183ZM17.0698 14.8268L12.243 19.8965L7.17324 15.0698C4.3733 12.404 4.26452 7.97318 6.93028 5.17324C9.59603 2.3733 14.0268 2.26452 16.8268 4.93028C19.6267 7.59603 19.7355 12.0268 17.0698 14.8268Z"
                          fill="currentColor"/>
                </svg>
                <span class="mx-1 text-sm">Safi</span>
            </div>
            <div class="w-full text-gray-700 md:text-center text-2xl font-semibold">
                Fitness
            </div>
            <div class="flex items-center justify-end w-full">
                <div>
                </div>
                <div class="flex sm:hidden">
                    <form action="" method="POST">
                        <input type="hidden" name="activity_id"
                               value="<?php echo htmlspecialchars($activityItem['id']); ?>">
                        <button type="submit"
                                class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-10 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <nav :class="isOpen ? '' : 'hidden'" class="sm:flex sm:justify-center sm:items-center mt-4">
            <div class="flex flex-col sm:flex-row">
                <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0" href="../index.php">Home</a>
                <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0" href="activities.php">Activities</a>
                <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0" href="reservations.php">Reservations</a>
                <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0" href="favoris.php">Favoris</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0" href="login.php">Login</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0"
                       href="Admin/dashboard.php">Dashboard</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<div class="h-screen bg-gray-100 pt-20">
    <h1 class="mb-10 text-center text-2xl font-bold">Cart Items</h1>
    <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
        <div class="rounded-lg md:w-3/4">
            <?php foreach ($cartItems as $cartItem): ?>
                <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
                    <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                        <div class="mt-5 sm:mt-0">
                            <h2 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($cartItem['id']); ?></h2>
                            <h2 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($cartItem['activity_name']); ?></h2>
                            <p class="mt-1 text-xs text-gray-700"><?php echo htmlspecialchars($cartItem['activity_type']); ?></p>
                            <p class="mt-1 text-xs text-gray-700"><?php echo htmlspecialchars($cartItem['activity_date']); ?></p>
                            <p class="mt-1 text-xs text-gray-700">MAD<?php echo htmlspecialchars($cartItem['activity_price']); ?></p>
                        </div>
                        <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                            <div class="flex items-center space-x-4">
                                <?php if (isset($_SESSION['user_id'])) : ?>
                                    <form action="reservationBackend.php" method="POST">
                                        <input type="hidden" name="activity_id" value="<?php echo htmlspecialchars($cartItem['activity_id']); ?>">
                                        <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($cartItem['id']); ?>">
                                        <button type="submit" class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                                data-ripple-light="true">
                                            Reserve It Now
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="cart_item_id" value="<?php echo htmlspecialchars($cartItem['id']); ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <!--        <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">-->
        <!--            <div class="mb-2 flex justify-between">-->
        <!--                <p class="text-gray-700">Subtotal</p>-->
        <!--                <p class="text-gray-700">$129.99</p>-->
        <!--            </div>-->
        <!--            <div class="flex justify-between">-->
        <!--                <p class="text-gray-700">Shipping</p>-->
        <!--                <p class="text-gray-700">$4.99</p>-->
        <!--            </div>-->
        <!--            <hr class="my-4"/>-->
        <!--            <div class="flex justify-between">-->
        <!--                <p class="text-lg font-bold">Total</p>-->
        <!--                <div class="">-->
        <!--                    <p class="mb-1 text-lg font-bold">$134.98 USD</p>-->
        <!--                    <p class="text-sm text-gray-700">including VAT</p>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <button class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">Check-->
        <!--                out-->
        <!--            </button>-->
        <!--        </div>-->
    </div>
</div>
</body>

</html>
