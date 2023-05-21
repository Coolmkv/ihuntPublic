<?php

if (isset($categories)) {
    echo '<h5>Help Categories</h5><ul>';
    foreach ($categories as $ct) {
        echo '<li>
            <a href="javascript:" onclick="getCategoryItem(' . $ct->helpId . ',\'category\')">' . $ct->categoryName . '</a><ul id="category' . $ct->helpId . '"></ul></li>';
    }
    echo '</ul>';
} else if (isset($categoryText)) {
    foreach ($categoryText as $ct) {
        echo '<div><h4>' . $ct->heading . '</h4>' . $ct->helpContent . '</div>';
    }
} else if (isset($searchText)) {
    foreach ($searchText as $st) {
        echo '<div><h5>Search Results</h5><h6>' . $st->heading . '</h6>' . $st->helpContent . '</div></hr>';
    }
} else {

}