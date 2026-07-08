<?php include 'header.php'; ?>

<div class="card-container">
    <?php
    $json_data = file_get_contents('data.json');
    $data = json_decode($json_data, true);

    if ($data && isset($data['categories'])) {
        foreach ($data['categories'] as $category) {
            echo '<div class="card">';
            echo '<h2>' . htmlspecialchars($category['title']) . '</h2>';
            echo '<ul>';
            if (isset($category['links'])) {
                foreach ($category['links'] as $link) {
                    echo '<li><a href="' . htmlspecialchars($link['url']) . '">' . htmlspecialchars($link['title']) . '</a></li>';
                }
            }
            echo '</ul>';
            echo '</div>';
        }
    } else {
        echo '<p>No data available to display.</p>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>
