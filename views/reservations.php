<?php
session_start();
include 'partials.php';
include '../classes/Activity.php';
include '../classes/Reservation.php';

$reservations = [];

if (isset($_SESSION['user_id'])) {
    $reservation = new Reservation($db);
    $reservations = $reservation->getUserReservations($_SESSION['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
    $reservation = new Reservation($db);
    $reservation_id = $_POST['reservation_id'];
    $reservation->deleteReservation($reservation_id);
    // Redirect or refresh as needed
    header("Location: reservations.php");
    exit();
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
<section class="bg-gray-100 px-4 text-gray-600 antialiased">
    <div class="flex mt-10 flex-col justify-center">
        <div class="mx-auto w-full max-w-2xl rounded-sm border border-gray-200 bg-white shadow-lg">
            <header class="border-b border-gray-100 px-5 py-4">
                <div class="font-semibold text-gray-800">Manage Reservations</div>
            </header>

            <div class="overflow-x-auto p-3">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-400">
                    <tr>
                        <th class="p-2">
                            <div class="text-left font-semibold">Activity Name</div>
                        </th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Activity Date</div>
                        </th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Activity Price</div>
                        </th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Reservation Date</div>
                        </th>
                        <th class="p-2">
                            <div class="text-center font-semibold">Action</div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">
                    <?php foreach ($reservations as $reservationItem): ?>
                        <tr>
                            <td class="p-2">
                                <div class="font-medium text-gray-800"><?php echo htmlspecialchars($reservationItem['activity_name']); ?></div>
                            </td>
                            <td class="p-2">
                                <div class="text-left"><?php echo htmlspecialchars($reservationItem['activity_date']); ?></div>
                            </td>
                            <td class="p-2">
                                <div class="text-left font-medium text-green-500"><?php echo htmlspecialchars($reservationItem['activity_price']); ?></div>
                            </td>
                            <td class="p-2">
                                <div class="text-left"><?php echo htmlspecialchars($reservationItem['created_at']); ?></div>
                            </td>
                            <td class="p-2">
                                <div class="flex justify-center">
                                    <form action="" method="POST">
                                        <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservationItem['id']); ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

</body>
</html>
