<?php
include '../partials.php';
include '../../connection.php';
include '../../classes/Activity.php';

$activity = new Activity($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $name = $_POST['ActivityName'];
        $type = $_POST['ActivityType'];
        $description = $_POST['ActivityDescription'];
        $price = $_POST['ActivityPrice'];
        $date = $_POST['ActivityDate'];

        $activity->createActivity($name, $type, $description, $price, $date);

        header("Location: dashboard.php");
        exit();
    } elseif (isset($_POST['delete'])) {
        $deleteId = $_POST['delete_id'];
        $activity->deleteActivity($deleteId);

        header("Location: dashboard.php");
        exit();
    }
}

$activities = $activity->getAllActivities();
?>

<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->

<div class="flex flex-col h-screen bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="md:flex items-center justify-between py-2 px-8 md:px-12">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800 md:text-3xl">
                    <a href="#">Fitness</a>
                </div>
                <div class="md:hidden">
                    <button type="button" class="block text-gray-800 hover:text-gray-700 focus:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path class="hidden" d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                            <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex flex-col md:flex-row hidden md:block -mx-2">
                <a href="../Home.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">Home</a>
                <a href="../logout.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">Logout</a>
                <a href="#" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">Contact</a>
            </div>
        </div>
    </nav>
    <div class="flex-1 flex">

        <div class="flex-1 p-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 p-2">
                <div class="bg-green-200 p-4 rounded-md mt-4">
                    <h2 class="text-gray-700 text-lg font-semibold pb-4">Activities</h2>
                    <div class="my-1"></div>
                    <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div>
                    <table class="w-full table-auto text-sm">
                        <thead>
                        <tr class="text-sm leading-normal">
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-left">
                                Name
                            </th>
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-left">
                                Type
                            </th>
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-right text-left">
                                Price
                            </th>
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-right text-left">
                                Date
                            </th>
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-right text-left">
                                Operation
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($activities as $activity): ?>
                            <tr class="hover:bg-grey-lighter">
                                <td class="py-2 px-4 border-b border-grey-light"><?php echo htmlspecialchars($activity['name']); ?></td>
                                <td class="py-2 px-4 border-b border-grey-light"><?php echo htmlspecialchars($activity['type']); ?></td>
                                <td class="py-2 px-4 border-b border-grey-light text-right"><?php echo htmlspecialchars($activity['price']); ?></td>
                                <td class="py-2 px-4 border-b border-grey-light text-right"><?php echo htmlspecialchars($activity['date']); ?></td>
                                <td class="py-2 px-4 border-b border-grey-light text-right">
                                    <form action="dashboard.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $activity['id']; ?>">
                                        <button type="submit" name="delete"class="inline-block p-3 text-center text-white transition bg-red-500 rounded-full shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none">
                                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-right mt-4">
                        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="min-w-auto w-80 h-10 bg-green-600 p-2 rounded-xl hover:bg-green-500 transition-colors duration-50 hover:animate-pulse ease-out text-white font-semibold">
                           New Activity
                        </button>
                    </div>
                </div>
                <div class="bg-blue-200 p-4 rounded-md mt-4">
                    <h2 class="text-gray-700 text-lg font-semibold pb-4">Reservations</h2>
                    <div class="my-1"></div>
                    <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div>
                    <table class="w-full table-auto text-sm">
                        <thead>
                        <tr class="text-sm leading-normal">
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-left">
                                Nombre
                            </th>
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-left">
                                Fecha
                            </th>
                            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light text-right text-left">
                                Monto
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hover:bg-grey-lighter">
                            <td class="py-2 px-4 border-b border-grey-light">Carlos Sánchez</td>
                            <td class="py-2 px-4 border-b border-grey-light">27/07/2023</td>
                            <td class="py-2 px-4 border-b border-grey-light text-right">$1500</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- popup de l'ajout-->
<div id="authentication-modal" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Ajouter une Activité
                </h3>
                <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" action="dashboard.php" method="POST">
                    <div>
                        <label for="ActivityName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name
                            of the Activity</label>
                        <input type="text" name="ActivityName" id="ActivityName"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="Name" required/>
                    </div>
                    <div>
                        <label for="ActivityType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type
                            of the Activity</label>
                        <input type="text" name="ActivityType" id="ActivityType"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="Type" required/>
                    </div>
                    <div>
                        <label for="ActivityDescription"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="ActivityDescription" id="ActivityDescription"
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                  placeholder="Description" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="ActivityPrice"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price of the
                                Activity</label>
                            <input type="number" name="ActivityPrice" id="ActivityPrice"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="MAD" required/>
                        </div>
                        <div>
                            <label for="ActivityDate"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of the
                                Activity</label>
                            <input type="date" name="ActivityDate" id="ActivityDate"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   required/>
                        </div>
                    </div>
                    <button type="submit" name="submit"
                            class="w-full mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


