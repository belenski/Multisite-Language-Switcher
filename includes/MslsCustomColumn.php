<?php
/**
 * MslsCustomColumn
 * @author Dennis Ploetner <re@lloc.de>
 * @since 0.9.8
 */

namespace lloc\Msls;

/**
 * Handling of existing/not existing translations in the backend listings of various post types
 *
 * @package Msls
 */
class MslsCustomColumn extends MslsMain implements HookInterface {

	/**
	 * Factory
	 *
	 * @codeCoverageIgnore
	 *
	 * @return HookInterface
	 */
	public static function init(): HookInterface {
		$options    = MslsOptions::instance();
<<<<<<< HEAD
		$collection = MslsBlogCollection::instance();
		$obj        = new self( $options, $collection );
=======
		$collection = msls_blog_collection();
		$obj        = new static( $options, $collection );
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

		if ( ! $options->is_excluded() ) {
			$post_type = MslsPostType::instance()->get_request();

			if ( ! empty( $post_type ) ) {
				add_filter( "manage_{$post_type}_posts_columns", [ $obj, 'th' ] );
				add_action( "manage_{$post_type}_posts_custom_column", [ $obj, 'td' ], 10, 2 );
				add_action( 'trashed_post', [ $obj, 'delete' ] );
			}
		}

		return $obj;
	}

	/**
	 * Table header
	 *
	 * @param array<string, string> $columns
	 *
	 * @return array<string, string>
	 */
	public function th( array $columns ): array {
		$blogs = $this->collection->get();

		if ( $blogs ) {
<<<<<<< HEAD
			$arr = [];

=======
			$html = '';
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
			foreach ( $blogs as $blog ) {
				$language = $blog->get_language();

				$icon = new MslsAdminIcon( null );
				$icon->set_language( $language );
				if( $this->options->admin_display === 'label' ) {
					$icon->set_icon_type( 'label' );
				} else {
					$icon->set_icon_type( 'flag' );					
				}

				if ( $post_id = get_the_ID() ) {
					$icon->set_id( $post_id );
					$icon->set_origin_language( 'it_IT' );
				}

				$html .= '<span class="msls-icon-wrapper ' . esc_attr( $this->options->admin_display ) . '">';
				$html .= $icon->get_icon();
				$html .= '</span>';
			}
<<<<<<< HEAD

			$columns['mslscol'] = implode( '&nbsp;', $arr );
=======
			$columns['mslscol'] = $html;
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		}

		return $columns;
	}

	/**
	 * Table body
	 *
	 * @param string $column_name
	 * @param int $item_id
	 *
	 * @return void
	 */
	public function td( string $column_name, int $item_id ): void {
		if ( 'mslscol' === $column_name ) {
			$blogs           = $this->collection->get();
			$origin_language = MslsBlogCollection::get_blog_language();
			if ( $blogs ) {
				$mydata = MslsOptions::create( $item_id );
				foreach ( $blogs as $blog ) {
					switch_to_blog( $blog->userblog_id );

					$language = $blog->get_language();

					$icon = MslsAdminIcon::create();
					$icon->set_language( $language );
					$icon->set_id( $item_id );
					$icon->set_origin_language( $origin_language );

					$icon->set_icon_type( 'action' );

					if ( $mydata->has_value( $language ) ) {
						$icon->set_href( $mydata->$language );
					}
	
					echo '<span class="msls-icon-wrapper ' . esc_attr( $this->options->admin_display ) . '">';
					echo $icon->get_a(); 
					echo '</span>';

					restore_current_blog();
				}
			}
		}
	}

}
