<?php
// Generate pagination controls
echo '<nav aria-label="Page navigation">';
echo '<ul class="pagination justify-content-end">';

// Previous Button
if ($current_page > 1) {
echo '<li class="page-item">
        <a class="page-link" href="#" data-page="' . ($current_page - 1) . '">Previous</a>
        </li>';
}

// Page Number Buttons
for ($i = 1; $i <= $total_pages; $i++) {
$active = $i == $current_page ? 'active' : '';
echo '<li class="page-item ' . $active . '">';
echo '<a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>';
echo '</li>';
}

// Next Button
if ($current_page < $total_pages) {
echo '<li class="page-item">
        <a class="page-link" href="#" data-page="' . ($current_page + 1) . '">Next</a>
        </li>';
}

echo '</ul>';
echo '</nav>';

?>