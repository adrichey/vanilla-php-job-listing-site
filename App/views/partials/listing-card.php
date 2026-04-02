<div class="rounded-lg shadow-md bg-white">
    <div class="p-4">
        <h2 class="text-xl font-semibold"><?= $listing->title ?></h2>
        <p class="text-gray-700 text-lg mt-2"><?= $listing->description ?></p>
        <ul class="my-4 bg-gray-100 p-4 rounded">
            <li class="mb-2"><strong>Salary:</strong> <?= formatCurrency($listing->salary) ?> <?= $listing->salary_frequency ?></li>
            <li class="mb-2">
                <strong>Location:</strong> <?= $listing->city ?>, <?= $listing->state ?>
                <span class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2">Local</span>
            </li>
            <li class="mb-2">
                <strong>Tags:</strong> <span><?= $listing->tags ?></span>
            </li>
        </ul>
        <a
        href="/listings/<?= $listing->id ?>"
        class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
        >
            Details
        </a>
    </div>
</div>