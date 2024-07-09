<?php
session_start();
include 'partials.php';
include '../connection.php';
include '../classes/Activity.php';
include '../classes/Reservation.php';


$activity = new Activity($db);
$activities = $activity->getAllActivities();

$randomImages = [
    'https://images.pexels.com/photos/601177/pexels-photo-601177.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
    'https://images.pexels.com/photos/179908/pexels-photo-179908.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
    'https://images.pexels.com/photos/949126/pexels-photo-949126.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
    'https://images.pexels.com/photos/1637451/pexels-photo-1637451.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
];

$reservation = new Reservation($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['activity_id'])) {
        $user_id = $_SESSION['user_id'];
        $activity_id = $_POST['activity_id'];

        $reservation->addReservation($user_id, $activity_id);

        header("Location: activities.php");
        exit();
    }
}
?>
<header>
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Your logo or site title -->
            <div class="hidden w-full text-gray-600 md:flex md:items-center">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Your logo SVG or text -->
                </svg>
                <span class="mx-1 text-sm">Safi</span>
            </div>
            <div class="w-full text-gray-700 md:text-center text-2xl font-semibold">
                Fitness
            </div>
            <div class="flex items-center justify-end w-full">
                <!-- Navigation links -->
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
                            <a class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0" href="Admin/dashboard.php">Dashboard</a>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($activities)) : ?>
            <?php foreach ($activities as $activityItem) : ?>
                <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                    <div class="flex items-end justify-end h-56 w-full bg-cover" style="background-image: url('<?php echo htmlspecialchars($randomImages[array_rand($randomImages)]); ?>')">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <form action="" method="POST">
                                <input type="hidden" name="activity_id" value="<?php echo htmlspecialchars($activityItem['id']); ?>">
                                <button type="submit" class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        <?php else : ?>
                            <a href="login.php"><button class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
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
