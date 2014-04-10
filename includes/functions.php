<?php



function bbp_list_private_subforums( $args ) {
	// Use passed integer as post_parent
	if ( is_numeric( $args ) )
		$args = array( 'post_parent' => $args );
	$post_stati[] = bbp_get_private_status_id() ;
	$post_stati[] = bbp_get_public_status_id();
	$args['post_status'] = implode( ',', $post_stati ) ;
	return $args ;
	}
add_filter( 'bbp_before_forum_get_subforums_parse_args', 'bbp_list_private_subforums' );	
	
//This function adds descriptions to the sub forums, and sends non-logged in or users who can't view to a sign-up page
function custom_list_forums( $args = '' ) {

	// Define used variables
	global $pfv_options ;
	$output = $sub_forums = $topic_count = $reply_count = $counts = '';
	$i = 0;
	$count = array();

	// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'before'            => '<ul class="bbp-forums-list">',
		'after'             => '</ul>',
		'link_before'       => '<li class="bbp-forum">',
		'link_after'        => '</li>',
		'count_before'      => ' (',
		'count_after'       => ')',
		'count_sep'         => ', ',
		'separator'         => '<br> ',
		'forum_id'          => '',
		'show_topic_count'  => true,
		'show_reply_count'  => true,
	), 'listb_forums' );
	
						
	
	// Loop through forums and create a list
	$sub_forums = bbp_forum_get_subforums( $r['forum_id'] );
	if ( !empty( $sub_forums ) ) {

		// Total count (for separator)
		$total_subs = count( $sub_forums );
		foreach ( $sub_forums as $sub_forum ) {
			$i++; // Separator count

			// Get forum details
			$count     = array();
			$show_sep  = $total_subs > $i ? $r['separator'] : '';
			$permalink = bbp_get_forum_permalink( $sub_forum->ID );
			$title     = bbp_get_forum_title( $sub_forum->ID );
			$content = bbp_get_forum_content($sub_forum->ID) ;
			if($pfv_options['activate_descriptions'] == true) {
			$content = bbp_get_forum_content($sub_forum->ID) ;
					}
					else {
					$content='';
					}
			

			// Show topic count
			if ( !empty( $r['show_topic_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['topic'] = bbp_get_forum_topic_count( $sub_forum->ID );
			}

			// Show reply count
			if ( !empty( $r['show_reply_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['reply'] = bbp_get_forum_reply_count( $sub_forum->ID );
			}

			// Counts to show
			if ( !empty( $count ) ) {
				$counts = $r['count_before'] . implode( $r['count_sep'], $count ) . $r['count_after'];
			}
			
			if($pfv_options['hide_counts'] == true) {
					$counts='';
					}
			//Build this sub forums link
			if (bbp_is_forum_private($sub_forum->ID)) {
				if (!current_user_can( 'read_private_forums' ) ) {
					if(!$pfv_options['redirect_page']) {
					$link='/home' ;
					}
					else {
					$link=$pfv_options['redirect_page'] ;
					}
					$output .= $r['before'].$r['link_before'] . '<a href="' .$link . '" class="bbp-forum-link">' . $title . $counts . '</a>' . $show_sep . $r['link_after'].'<div class="bbp-forum-content">'.$content.'</div>'.$r['after'];
				}
				else {
				$output .= $r['before'].$r['link_before'] . '<a href="' . esc_url( $permalink ) . '" class="bbp-forum-link">' . $title . $counts . '</a>' . $show_sep . $r['link_after'].'<div class="bbp-forum-content">'.$content.'</div>'.$r['after'];
				}
			}
			else {
			$output .= $r['before'].$r['link_before'] . '<a href="' . esc_url( $permalink ) . '" class="bbp-forum-link">' . $title . $counts . '</a>' . $show_sep . $r['link_after'].'<div class="bbp-forum-content">'.$content.'</div>'.$r['after'];
			}
	}
	 //Output the list
		return $output ;
	
}
}
add_filter('bbp_list_forums', 'custom_list_forums' );

function custom_freshness_link( $forum_id = 0 ) {
global $pfv_options ;
		$forum_id  = bbp_get_forum_id( $forum_id );
		$active_id = bbp_get_forum_last_active_id( $forum_id );
		$link_url  = $title = '';
		$forum_title= bbp_get_forum_title ($forum_id) ;

		if ( empty( $active_id ) )
			$active_id = bbp_get_forum_last_reply_id( $forum_id );

		if ( empty( $active_id ) )
			$active_id = bbp_get_forum_last_topic_id( $forum_id );

		if ( bbp_is_topic( $active_id ) ) {
			$link_url = bbp_get_forum_last_topic_permalink( $forum_id );
			$title    = bbp_get_forum_last_topic_title( $forum_id );
			$forum_id_last_active = bbp_get_topic_forum_id($active_id);
		} elseif ( bbp_is_reply( $active_id ) ) {
			$link_url = bbp_get_forum_last_reply_url( $forum_id );
			$title    = bbp_get_forum_last_reply_title( $forum_id );
			$forum_id_last_active = bbp_get_reply_forum_id($active_id);
		}

		$time_since = bbp_get_forum_last_active_time( $forum_id );

		if ( !empty( $time_since ) && !empty( $link_url ) ) {
		
			if ( bbp_is_forum_private($forum_id_last_active)) {
				if (current_user_can( 'read_private_forums' ) ) {
				$anchor = '<a href="' . esc_url( $link_url ) . '" title="' . esc_attr( $title ) . '">' . esc_html( $time_since ) . '</a>';
				}
				else {
					if(!$pfv_options['redirect_page']) {
					$link='/home' ;
					}
					else {
					$link=$pfv_options['redirect_page'] ;
					}
						if ($pfv_options['set_freshness_message'] == true) {
						$title=$pfv_options['freshness_message'] ;
						$anchor = '<a href="' . $link . '" title="' . esc_attr( $title ) . '">' .$title. '</a>';
						}
						else{
						$anchor = '<a href="' . $link . '" title="' . esc_attr( $title ) . '">' .esc_html( $time_since ) .'</a>';
						}
				}
			}
			else {
			$anchor = '<a href="' . esc_url( $link_url ) . '" title="' . esc_attr( $title ) . '">' .esc_html( $time_since ). '</a>';
			}
		}
		else
			$anchor = esc_html__( 'No Topics', 'bbpress' );

		return $anchor;
	}

add_filter('bbp_get_forum_freshness_link', 'custom_freshness_link' );



function pfv_remove_protected_title($title) {
	global $pfv_options ;
	if($pfv_options['activate_remove_private_prefix'] == true) {
	return '%s';
}
else {
Return $title ;
}
}
add_filter('protected_title_format', 'pfv_remove_protected_title');


function pfv_remove_private_title($title) {
	global $pfv_options ;
	if($pfv_options['activate_remove_private_prefix'] == true) {
	return '%s';
}
else {
return $title ;
}
}
add_filter('private_title_format', 'pfv_remove_private_title');
