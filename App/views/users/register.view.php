<?php
loadPartial('head');
loadPartial('navbar');
?>

<!-- Registration Form Box -->
<div class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-500 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Register</h2>
        <?php loadPartial('form-errors', ['errors' => $errors ?? []]); ?>
        <form method="POST" action="/register">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    Full Name
                </label>
                <input
                id="name"
                type="text"
                name="name"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                />
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    Email
                </label>
                <input
                id="email"
                type="email"
                name="email"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                />
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    City
                </label>
                <input
                id="city"
                type="text"
                name="city"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                />
            </div>
            <div class="mb-4">
                <label for="state" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    State
                </label>
                <input
                id="state"
                type="text"
                name="state"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                />
            </div>
            <div class="mb-4">
                <label for="zip_code" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    ZIP Code
                </label>
                <input
                id="zip_code"
                type="text"
                name="zip_code"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    Password
                </label>
                <input
                id="password"
                type="password"
                name="password"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                />
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    Confirm Password
                </label>
                <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                />
            </div>
            <button
            type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none"
            >
                Register
            </button>

            <p class="mt-4 text-gray-500">
                Already have an account?
                <a class="text-blue-900" href="/login">Login</a>
            </p>
        </form>
    </div>
</div>

<?php
loadPartial('footer');
