<?php
loadPartial('head');
loadPartial('navbar');
loadPartial('showcase-search');
loadPartial('top-banner');
?>

<!-- Post a Job Form Box -->
<section class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Create Job Listing</h2>
        <?php if (!empty($errors)): ?>
            <div class="message border rounded bg-red-100 border-red-500 text-red-500 p-3 my-3">
                <p>The following fields are required:</p>
                <ul class="list-disc ml-4">
                <?php foreach ($errors as $error): ?>
                    <li><?= $labels[$error] ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <!--
        <div class="message bg-green-100 p-3 my-3">
            This is a success message.
        </div>
        -->
        <form method="POST" action="/listings">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Job Info
            </h2>
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['title'] ?> <span class="text-red-500">*</span>
                </label>
                <input
                id="title"
                type="text"
                name="title"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['title'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['description'] ?> <span class="text-red-500">*</span>
                </label>
                <textarea
                id="description"
                name="description"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                ><?= $listing['description'] ?></textarea>
            </div>
            <div class="mb-4">
                <label for="salary" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['salary'] ?>
                </label>
                <input
                id="salary"
                type="text"
                name="salary"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['salary'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="salary_frequency" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['salary_frequency'] ?>
                </label>
                <select
                id="salary_frequency"
                name="salary_frequency"
                class="w-full px-4 py-2 border rounded focus:outline-none bg-white"
                >
                    <option value=""></option>
                    <option value="annually"<?= $listing['salary_frequency'] == 'annually' ? ' selected' : '' ?>>Annually</option>
                    <option value="monthly"<?= $listing['salary_frequency'] == 'monthly' ? ' selected' : '' ?>>Monthly</option>
                    <option value="bi_weekly"<?= $listing['salary_frequency'] == 'bi_weekly' ? ' selected' : '' ?>>Bi-Weekly</option>
                    <option value="weekly"<?= $listing['salary_frequency'] == 'weekly' ? ' selected' : '' ?>>Weekly</option>
                    <option value="per_project"<?= $listing['salary_frequency'] == 'per_project' ? ' selected' : '' ?>>Per Project</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="requirements" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['requirements'] ?>
                </label>
                <input
                id="requirements"
                type="text"
                name="requirements"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['requirements'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="benefits" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['benefits'] ?>
                </label>
                <input
                id="benefits"
                type="text"
                name="benefits"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['benefits'] ?>"
                />
            </div>
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Company Info & Location
            </h2>
            <div class="mb-4">
                <label for="company" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['company'] ?>
                </label>
                <input
                id="company"
                type="text"
                name="company"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['company'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['address'] ?>
                </label>
                <input
                id="address"
                type="text"
                name="address"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['address'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['city'] ?> <span class="text-red-500">*</span>
                </label>
                <input
                id="city"
                type="text"
                name="city"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['city'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="state" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['state'] ?> <span class="text-red-500">*</span>
                </label>
                <input
                id="state"
                type="text"
                name="state"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['state'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="zip_code" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['zip_code'] ?> <span class="text-red-500">*</span>
                </label>
                <input
                id="zip_code"
                type="text"
                name="zip_code"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['zip_code'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['phone'] ?>
                </label>
                <input
                id="phone"
                type="text"
                name="phone"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['phone'] ?>"
                />
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
                    <?= $labels['email'] ?> <span class="text-red-500">*</span>
                </label>
                <input
                id="email"
                type="email"
                name="email"
                class="w-full px-4 py-2 border rounded focus:outline-none"
                value="<?= $listing['email'] ?>"
                />
            </div>
            <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Save
            </button>
            <a
            href="/"
            class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none"
            >
                Cancel
            </a>
        </form>
    </div>
</section>

<?php
loadPartial('bottom-banner');
loadPartial('footer');
