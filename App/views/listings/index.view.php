<?php
loadPartial('head');
loadPartial('navbar');
loadPartial('showcase-search');
loadPartial('top-banner');
?>

<!-- Job Listings -->
<section>
    <div class="container mx-auto p-4 mt-4">
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">All Jobs</div>
        <?php loadPartial('messages'); ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <?php foreach ($listings as $listing): ?>
                <?php loadPartial('listing-card', [
                    'listing' => $listing,
                ]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
loadPartial('bottom-banner');
loadPartial('footer');
