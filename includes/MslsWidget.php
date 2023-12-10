<?php
/**
 * MslsWidget
 * @author Dennis Ploetner <re@lloc.de>
 * @since 0.9.8
 */

namespace lloc\Msls;

use WP_Widget;

/**
 * The standard widget of the Multisite Language Switcher
 * @package Msls
 */
class MslsWidget extends WP_Widget {

	public $id_base = 'mslswidget';

	public const FORMNAME = 'mslsform';

	/**
	 * Constructor
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct() {
		parent::__construct( 
			$this->id_base, 
			apply_filters(
				'msls_widget_title',
				__( 'Multisite Language Switcher', 'multisite-language-switcher' ) 
			)
		);
	}

	/**
	 * Output of the widget in the frontend
	 *
	 * @param array<string, mixed> $args
	 * @param array<string, mixed> $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$default = [
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		];

		$args = wp_parse_args( $args, $default );

		/** This filter is documented in wp-includes/default-widgets.php */
<<<<<<< HEAD
		$title = apply_filters('widget_title', $instance['title'] ?? '', $instance, $this->id_base );
=======
		$title = apply_filters( 'widget_title', $instance['title'] ?? '', $instance, $this->id_base );
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		if ( $title ) {
			$title = $args['before_title'] . esc_attr( $title ) . $args['after_title'];
		}

		$content = MslsOutput::init()->__toString();
		if ( '' === $content ) {
			$text    = __( 'No available translations found', 'multisite-language-switcher' );
			$content = apply_filters( 'msls_widget_alternative_content', $text );
		}

		echo $args['before_widget'], $title, $content, $args['after_widget'];
	}

	/**
	 * Update widget in the backend
	 *
	 * @param array<string, mixed> $new_instance
	 * @param array<string, mixed> $old_instance
	 *
	 * @return array<string, mixed>
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( isset( $new_instance['title'] ) ) {
			$instance['title'] = strip_tags( $new_instance['title'] );
		}

		return $instance;
	}

	/**
	 * Display an input-form in the backend
	 *
	 * @param array<string, mixed> $instance
	 *
<<<<<<< HEAD
	 * @return string
=======
	 * @return void
>>>>>>> 0190c8e6 (MslsWidget class fully tested)
	 */
	public function form( $instance ): string {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		printf(
			'<p><label for="%1$s">%2$s:</label> <input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" /></p>',
			$this->get_field_id( 'title' ),
			__( 'Title', 'multisite-language-switcher' ),
			$this->get_field_name( 'title' ),
			$title
		);

		return self::FORMNAME;
	}

}
