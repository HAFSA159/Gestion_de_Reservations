<?php
session_start();
include 'partials.php';
include '../connection.php';
include '../classes/Activity.php';
include '../classes/Reservation.php';
include '../classes/Cart.php';


$activity = new Activity($db);
$activities = $activity->getAllActivities();
// var_dump($activities);

$randomImages = [
    'https://images.pexels.com/photos/601177/pexels-photo-601177.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
    'https://images.pexels.com/photos/179908/pexels-photo-179908.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
    'https://images.pexels.com/photos/949126/pexels-photo-949126.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
    'https://images.pexels.com/photos/1637451/pexels-photo-1637451.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
];

if (isset($_SESSION['user_id'])) {
    $cart = new Cart($_SESSION['user_id'], $db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['activity_id'])) {
            $activity_id = $_POST['activity_id'];

            $cart->addActivityToCart($activity_id);

            header("Location: activities.php");
            exit();
        }
    }
}
?>

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
                    <a href="cart.php">
                        <div class="relative py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="file: mt-4 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                            </svg>
                        </div>
                    </a>
                </div>
                <div class="flex sm:hidden">
                    <form action="" method="POST">
                        <input type="hidden" name="activity_id" value="<?php echo htmlspecialchars($activityItem['id']); ?>">
                        <button type="submit" class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-10 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
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


<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($activities)) : ?>
            <?php foreach ($activities as $activityItem) : ?>
                <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                    <div class="flex items-end justify-end h-56 w-full bg-cover"
                         style="background-image: url('<?php echo htmlspecialchars($randomImages[array_rand($randomImages)]); ?>')">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <div class="flex w-full justify-end items-center">
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
                                <button onclick="addToFavorites(<?php echo $activityItem['id']; ?>)" class="p-2 rounded-full bg-red-600 text-white mx-5 -mb-6 hover:bg-red-500 focus:outline-none focus:bg-red-500">
                                    <i class="fas fa-heart text-lg leading-none"></i>
                                </button>
                            </div>
                        <?php else : ?>
                            <a href="login.php">
                                <button class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase"><?php echo htmlspecialchars($activityItem['name']); ?></h3>
                        <span class="text-gray-500 mt-2"><?php echo htmlspecialchars($activityItem['price']); ?> MAD</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
        <p>No activities found.</p>
        <?php endif; ?>
    </div>
</section>