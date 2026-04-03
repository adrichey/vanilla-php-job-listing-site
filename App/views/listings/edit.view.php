<?php
loadPartial('head');
loadPartial('navbar');
?>

<!-- Edit a Job Form Box -->
<section class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>
        <?php loadPartial('form-errors', ['errors' => $errors ?? []]); ?>
        <!--
        <div class="message bg-green-100 p-3 my-3">
            This is a success message.
        </div>
        -->
        <form method="POST" action="/listings/<?= $listing->id ?>">
            <input type="hidden" name="_method" value="PUT" />
            <?php loadView('listings/edit-listing-form', ['listing' => $listing]); ?>
            <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Save
            </button>
            <a
            href="/listings/<?= $listing->id ?>"
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
