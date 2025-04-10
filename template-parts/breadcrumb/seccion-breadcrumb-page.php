<div class="breadcrumbs">
    <p id="breadcrumbs" class="claro">
        <span>
            <a style="text-decoration: none!important;" href="/"
            data-wpel-link="internal">Inicio</a>
        </span> /
        <span>
            <?php 
                if (is_single() || is_page()) {
                    echo '<a style="text-decoration: none!important; font-weight: bold;" href="' . get_permalink() . '" data-wpel-link="internal">' . get_the_title() . '</a>';
                } elseif (is_category()) {
                    echo '<a style="text-decoration: none!important; font-weight: bold;" href="' . get_category_link(get_query_var('cat')) . '" data-wpel-link="internal">' . single_cat_title('', false) . '</a>';
                } elseif (is_tag()) {
                    echo '<a style="text-decoration: none!important; font-weight: bold;" href="' . get_tag_link(get_query_var('tag_id')) . '" data-wpel-link="internal">' . single_tag_title('', false) . '</a>';
                } elseif (is_author()) {
                    echo '<a style="text-decoration: none!important; font-weight: bold;" href="' . get_author_posts_url(get_the_author_meta('ID')) . '" data-wpel-link="internal">' . get_the_author() . '</a>';
                } elseif (is_archive()) {
                    echo '<a style="text-decoration: none!important; font-weight: bold;" href="' . get_permalink() . '" data-wpel-link="internal">' . get_the_archive_title() . '</a>';
                } else {
                    echo '<a style="text-decoration: none!important; font-weight: bold;" href="' . get_permalink() . '" data-wpel-link="internal">Title Page</a>';
                }
            ?>
        </span>
    </p>
</div>