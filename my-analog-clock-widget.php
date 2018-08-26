<?php

/*
Plugin Name: My Analog Clock Widget
*/

/*
 * Register our Widget
 */
add_action( 'widgets_init', function() {
	register_widget( 'MyAnalogClockWidget' );
} );

/**
 * Register our JavaScript
 */
add_action( 'wp_enqueue_scripts', function() {
	wp_register_script( 'my-analog-clock-p5', 'https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.1/p5.min.js', [], '0.7.1' );
	wp_register_script( 'my-analog-clock', plugin_dir_url( __FILE__ ) . 'js/clock.js', [ 'my-analog-clock-p5' ], '0.1' );
} );

/**
 * Create our Widget
 */
class MyAnalogClockWidget extends WP_Widget {

	/**
	 * Set the id / name / description
	 */
	function __construct() {
		parent::__construct(
			'analog_clock_widget',
			esc_html__( 'Analog Clock', 'analog-clock-widget' ),
			[
				'description' => esc_html__( 'Displays an analog clock using the current time.', 'analog-clock-widget' ),
			]
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		wp_enqueue_script( 'my-analog-clock' );

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		echo '<div id="my-analog-clock-container"><!-- Our clock will go here --></div>';

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Current Time', 'analog-clock-widget' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_attr_e( 'Title:', 'analog-clock-widget' ); ?>
			</label>

			<input type="text"
			       class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = [];
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}
}
