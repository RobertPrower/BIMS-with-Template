<?php
// Generate pagination controls
// echo '<nav aria-label="Page navigation">';
// echo '<ul class="pagination main-pagination justify-content-end">';

// // Previous Button
// if ($current_page > 1) {
// echo '<li class="page-item">
//         <a class="page-link pagination-control " href="#" data-page="' . ($current_page - 1) . '">Previous</a>
//         </li>';
// }

// // Page Number Buttons
// for ($i = 1; $i <= $total_pages; $i++) {
// $active = $i == $current_page ? 'active' : '';
// echo '<li class="page-item ' . $active . '">';
// echo '<a class="page-link pagination-control" href="#" data-page="' . $i . '">' . $i . '</a>';
// echo '</li>';
// }

// // Next Button
// if ($current_page < $total_pages) {
// echo '<li class="page-item">
//         <a class="page-link pagination-control " href="#" data-page="' . ($current_page + 1) . '">Next</a>
//         </li>';
// }

// echo '</ul>';
// echo '</nav>';

// For the pagination controls of for the modal
echo '<nav aria-label="Page navigation">';
echo '<ul class="pagination main-pagination justify-content-end">';

// Make the previous button only appear once the page is more than one
if ($current_page > 1) {
    echo '<li class="page-item "><a class="page-link pagination-control" href="#" data-page="' . ($current_page - 1) . '">Previous</a></li>';
}

$range = 5; // Max number of entries to be displayed
$half_range = floor($range / 2);//Round down to the nearest value

// Calculate the start and end page numbers
$start_page = max(1, $current_page - $half_range);
$end_page = min($total_pages, $current_page + $half_range);

// Ensure that exactly 10 page numbers are displayed if possible
if ($end_page - $start_page + 1 < $range) {
    if ($start_page == 1) {
        // If at the start, extend the end
        $end_page = min($total_pages, $start_page + $range - 1);
    } elseif ($end_page == $total_pages) {
        // If at the end, shift the start back
        $start_page = max(1, $end_page - $range + 1);
    }
}

// To generate the Page number buttons
for ($i = $start_page; $i <= $end_page; $i++) {
    $active = $i == $current_page ? 'active' : '';
    echo '<li class="page-item ' . $active . '"><a class="page-link pagination-control" href="#" data-page="' . $i . '">' . $i . '</a></li>';
}

// Next button
if ($current_page < $total_pages) {
    echo '<li class="page-item"><a class="page-link pagination-control" href="#" data-page="' . ($current_page + 1) . '">Next</a></li>';
}

// echo '</ul>';
// echo '</nav>';

?>