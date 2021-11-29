<?php
/*
 * Display WordPress Post as Event
 * @author: Sasky
*/


function ssky_upcoming_events_post( $atts ) {

    // The query to locate scheduled posts on your website
    $the_query = new WP_Query(array(
        //'post_status' => 'publish',
        'posts_per_page' => $atts['display'],
        'orderby' => 'date',
        'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $atts['category_id'],
			),
		),
		'date_query'    => array(
			'column'  => 'post_date',
			'after'   => '- 0 days'
		)
    ));
    
    // The following If statement will display all scheduled posts
    if ( $the_query->have_posts() ) {
        $output.= '<div class="latest_post_holder date_in_box "><ul>';
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $slug = get_post_field( 'post_name', get_the_ID() );
                $output .= '<li class="clearfix">
                                <div class="latest_post_date">
                                    <div class="post_publish_day">' . get_the_time('d') . '</div>
                                    <div class="post_publish_month">' . get_the_time('M') . '</div>
                                </div>
                                <div class="latest_post">
                                    <div class="latest_post_text">
                                        <div class="latest_post_text_inner">
                                            <h5 class="latest_post_title ">
                                                <a href="' . site_url() . '/' . $slug  . '">' . get_the_title() . '</a>
                                            </h5>
                                            <span class="post_infos">
                                                 <span class="date_hour_holder">
                                                    <span style="font-size: 12px; font-weight: 300;" class="date">' . get_the_time('H:i A') . '</span>
                                                </span>
                                            </span>
                                            <p class="excerpt">' . get_the_excerpt() . '</p>
                                        </div>
                                    </div>
                                </div></li>';
            }
        $output.= '</ul></div>';
    } else {
        // Message when no scheduled posts are found
        $output .= '<p>No Upcoming events found.</p>';
    }
    
    // Reset post data
    wp_reset_postdata();
    
    // Return output
    return $output;
}

// Add shortcode
add_shortcode('ssky_upcoming_events', 'ssky_upcoming_events_post');

