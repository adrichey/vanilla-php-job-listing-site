<h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
    Job Info
</h2>
<div class="mb-4">
    <label for="title" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
        Job Title <span class="text-red-500">*</span>
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
        Job Description <span class="text-red-500">*</span>
    </label>
    <textarea
    id="description"
    name="description"
    class="w-full px-4 py-2 border rounded focus:outline-none"
    ><?= $listing['description'] ?></textarea>
</div>
<div class="mb-4">
    <label for="salary" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
        Salary <span class="text-red-500">*</span>
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
        Salary Frequency <span class="text-red-500">*</span>
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
        <option value="hourly"<?= $listing['salary_frequency'] == 'hourly' ? ' selected' : '' ?>>Hourly</option>
        <option value="per_project"<?= $listing['salary_frequency'] == 'per_project' ? ' selected' : '' ?>>Per Project</option>
    </select>
</div>
<div class="mb-4">
    <label for="requirements" class="block text-gray-700 text-base font-semibold mb-2 ml-2">
        Requirements
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
        Benefits
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
        Company Name
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
        Address
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
        City <span class="text-red-500">*</span>
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
        State <span class="text-red-500">*</span>
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
        ZIP Code <span class="text-red-500">*</span>
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
        Phone
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
        Email Address For Applications <span class="text-red-500">*</span>
    </label>
    <input
    id="email"
    type="email"
    name="email"
    class="w-full px-4 py-2 border rounded focus:outline-none"
    value="<?= $listing['email'] ?>"
    />
</div>