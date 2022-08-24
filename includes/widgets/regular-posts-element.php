<?php
/**
 * Regular Posts Element.
 *
 * Elementor widget that inserts posts content into the page.
 *
 * @since 1.0.0
 */

// Regular Posts Type
function get_regular_post_type() {

	$post_types = get_post_types( array( 'public' => true ), 'objects' );
	$result = array();

	if ( empty( $post_types ) ) {
		return $result;
	}

	foreach ( $post_types as $slug => $post_type ) {
		$result[ $slug ] = $post_type->label;
	}

	return $result;

}

// Regular Posts Categories
function get_regular_categories( ){
	$elements = get_terms( 'category', array('hide_empty' => false) );
	$post_cat_array = array();

	if( !empty($elements) ){

		foreach ($elements as $element) {
			$info = get_term( $element, 'category');
			$post_cat_array[ $info->term_id ] = $info->name;
		}
	}
	return $post_cat_array;
}

class Regular_Posts_Element extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'regular-posts-element';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Regular Posts Element', 'regular-posts-element' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'regular_elements-icon eicon-post-list';
	}

	/**
	 * Get widget Style.
	 */

	public function get_style_depends() {

		wp_register_style( 'regular-posts-element', plugins_url( '../../assets/css/frontend/regular-posts-element.css', __FILE__ ) );

		return [
			'regular-posts-element',
		];

	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'regular-posts-element' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_posts_image',
			[
				'label' => __( 'Show Image?', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'regular-posts-element' ),
				'label_off' => __( 'Hide', 'regular-posts-element' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_posts_title',
			[
				'label' => __( 'Show Title?', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'regular-posts-element' ),
				'label_off' => __( 'Hide', 'regular-posts-element' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'posts_title_length',
			[
				'label' => __( 'Title Length?', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'regular-posts-element' ),
				'label_off' => __( 'Hide', 'regular-posts-element' ),
				'default' => 'no',
				'condition' => [
					'show_posts_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'posts_title_length_number',
			[
				'label' => __( 'Number', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				/** This filter is documented in wp-includes/formatting.php */
				'default' => apply_filters( 'posts_title_length_number', 5 ),
				'condition' => [
					'posts_title_length' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_posts_excerpt',
			[
				'label' => __( 'Show excerpt?', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'regular-posts-element' ),
				'label_off' => __( 'Hide', 'regular-posts-element' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'posts_excerpt_length',
			[
				'label' => __( 'Excerpt Length?', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'regular-posts-element' ),
				'label_off' => __( 'Hide', 'regular-posts-element' ),
				'default' => 'no',
				'condition' => [
					'show_posts_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'posts_excerpt_length_number',
			[
				'label' => __( 'Number', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				/** This filter is documented in wp-includes/formatting.php */
				'default' => apply_filters( 'posts_excerpt_length_number', 15 ),
				'condition' => [
					'posts_excerpt_length' => 'yes',
				],
			]
		);

		$this->add_control(
			'posts_meta_data',
			[
				'label' => __( 'Meta Data', 'regular-posts-element' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' =>[ 'the-author', 'the-date' ],
				'multiple' => true,
				'options' => [
					'the-author' => __( 'Author', 'regular-posts-element' ),
					'the-date' => __( 'Date', 'regular-posts-element' ),
					'the-time' => __( 'Time', 'regular-posts-element' ),
				],
			]
		);

		$this->add_control(
			'posts_meta_separator',
			[
				'label' => __( 'Separator Between', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '///',
				'selectors' => [
					'{{WRAPPER}} .post-content-area .meta-tag span + span:before' => 'content: "{{VALUE}}"',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'posts_query_section',
			[
				'label' => __( 'Query', 'regular-posts-element' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Post Type
		$this->add_control(
			'regular_posts_posttype',
			[
				'label' => __( 'Source', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'post',
				'options' => get_regular_post_type(),

			]
		);

        // Posts Status
		$this->add_control(
			'regular_post_status',
			[
				'label' => __( 'Posts Status', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default'=> 'publish',
				'options' => [
					'publish' => esc_html__( 'Publish', 'regular-posts-element' ),
					'pending' => esc_html__( 'Pending', 'regular-posts-element' ),
					'draft' => esc_html__( 'Draft', 'regular-posts-element' ),
					'future' => esc_html__( 'Future', 'regular-posts-element' ),
					'private' => esc_html__( 'Private', 'regular-posts-element' ),
				],
			]
		);

        // OrderBy
		$this->add_control(
			'regular_posts_orderby',
			[
				'label' => __( 'Orderby', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'title',	
				'options' => [
					'title' => __('Title','regular-posts-element'),
					'date' => __('Date','regular-posts-element'),
					'rand' => __('Random','regular-posts-element'),
				],
			]
		);

        // Order
		$this->add_control(
			'regular_posts_order',
			[
				'label' => __( 'Order', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ASC',	
				'options' => [
					'ASC' => __('ASC','regular-posts-element'),
					'DESC' => __('DESC','regular-posts-element'),
				],
			]
		);

        // Total Posts
		$this->add_control(
			'total_posts_number',
			[
				'label' => __( 'Total Item', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => -1,
			]
		);

		// Posts Category
		$this->add_control(
			'select_posts_categories',
			[
				'label' => __( 'Show Category Base?', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default'=>'no',
			]
		);

		$this->add_control(
			'posts_categories_ids',
			[
				'label' => __( 'Select Category', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => get_regular_categories(),
				'condition'=>[
					'select_posts_categories' =>'yes',
				],

			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'regular-posts-element' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Columns
		$this->add_responsive_control(
			'posts_layout_columns',
			[
				'label' => __( 'Columns', 'regular-posts-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'6' => __('6 Columns','regular-posts-element'),
					'5' => __('5 Columns','regular-posts-element'),
					'4' => __('4 Columns','regular-posts-element'),
					'3' => __('3 Columns','regular-posts-element'),
					'2' => __('2 Columns','regular-posts-element'),
					'1' => __('1 Columns','regular-posts-element'),
				],
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .single-regular-posts-column' => 'width: calc( 100% / {{SIZE}} ); display:inline-block;',
				],
			]
		);

		

		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$show_posts_image =$settings['show_posts_image'];
		$show_posts_title =$settings['show_posts_title'];
		$posts_title_length =$settings['posts_title_length'];
		$posts_title_length_number =$settings['posts_title_length_number'];
		$show_posts_excerpt =$settings['show_posts_excerpt'];
		$posts_excerpt_length =$settings['posts_excerpt_length'];
		$posts_excerpt_length_number =$settings['posts_excerpt_length_number'];
		$posts_meta_data =$settings['posts_meta_data'];
		$regular_posts_posttype =$settings['regular_posts_posttype'];
		$posts_categories_ids = $settings['posts_categories_ids'];
		$total_posts_number = $settings['total_posts_number'];
		$regular_posts_orderby = $settings['regular_posts_orderby'];
		$regular_posts_order = $settings['regular_posts_order'];
		$regular_post_status = $settings['regular_post_status'];


		if($settings['select_posts_categories'] == 'yes'):
	        $reqular_post_query = new WP_Query(array(
	        	'post_type' => $regular_posts_posttype,
				'posts_per_page' => $total_posts_number,
				'orderby'	=> $regular_posts_orderby,
				'order'	=> $regular_posts_order,
				'tax_query' => array(
			        array(
			            'taxonomy' => 'category',
			            'field'    => 'term_id',
			            'terms'    => $posts_categories_ids,
			        ),
			    ),
			    'post_status' => $regular_post_status,
	        )); 
	    else:
 			$reqular_post_query = new WP_Query(array(
	        	'post_type' => $regular_posts_posttype,
				'posts_per_page' => $total_posts_number,
				'orderby'	=> $regular_posts_orderby,
				'order'	=> $regular_posts_order,
			    'post_status' => $regular_post_status,
	        )); 
	    endif;
	    ?>
		<div id="regular-posts-element" class="regular-posts-element" style="display:flex;flex-wrap:wrap;">
			<?php
				
			 if($reqular_post_query->have_posts()) : while($reqular_post_query->have_posts()) : $reqular_post_query->the_post();
				
			?>
	    		<div class="single-regular-posts-column">
	    			<div class="single-regular-post-content-area">

						<?php if($show_posts_image == 'yes'):?>
			    			<div class="regular-post-thumbnail">
								<a href="<?php the_permalink();?>" class="regular-post-link">
									<?php the_post_thumbnail('thumbnail');?>
								</a>
			    			</div>
			    		<?php endif;?>

						<div class="post-content-area">
							<?php if($show_posts_title == 'yes'): ?>
								<h2 class="regular-post-title">
									<a href="<?php the_permalink();?>" class="regular-post-title-link"> 
										<?php 
											if($posts_title_length == 'yes'){
												echo wp_trim_words(get_the_title(), $posts_title_length_number );
											}else{
												the_title();
											}
										?> 
									</a>
								</h2>
								<div class="regular-post-excerpt"> 
									<p>
										<?php 
											if($posts_excerpt_length == 'yes'){
												echo wp_trim_words(get_the_excerpt(), $posts_excerpt_length_number );
											}else{
												the_excerpt();
											}
										?> 
									</p>
								</div>
							<?php endif; ?>
							<div class="post-meta-tag">
							    <?php if(!empty(in_array( 'the-author', $posts_meta_data ))): ?>

									<span>By <?php the_author();?> </span>

								<?php endif; if(!empty(in_array( 'the-date', $posts_meta_data ))): ?>

									<span> <?php echo get_the_date();?> </span>

								<?php endif; if(!empty(in_array( 'the-time', $posts_meta_data ))): ?>

									<span> <?php the_time();?> </span>

								<?php endif;?>
							</div>
						</div>		
	    					
					</div>
  				</div>
  			<?php
				endwhile; endif;
				/* Restore original Post Data */
				wp_reset_postdata();
			?>				
		</div>
		<?php

		

	}

}