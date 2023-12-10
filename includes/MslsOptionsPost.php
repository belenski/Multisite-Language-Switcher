<?php
/**
 * MslsOptionsPost
 * @author Dennis Ploetner <re@lloc.de>
 * @since 0.9.8
 */

namespace lloc\Msls;

/**
 * Post options
 * @package Msls
 */
class MslsOptionsPost extends MslsOptions {

	/**
	 * @var string
	 */
	protected $sep = '_';

	/**
	 * @var string
	 */
	protected $autoload = 'no';

	/**
	 * Get postlink
	 *
	 * @param string $language
	 *
	 * @return string
	 */
	public function get_postlink( string $language ): string {
		if ( ! $this->has_value( $language ) ) {
			return '';
		}

		$post = get_post( (int) $this->__get( $language ) );
		if ( is_null( $post ) || 'publish' != $post->post_status ) {
			return '';
		}

		if ( ! isset( $this->with_front ) ) {
			$post_object      = get_post_type_object( $post->post_type );
			$this->with_front = ! empty( $post_object->rewrite['with_front'] );
		}

<<<<<<< HEAD
=======
		global $current_site;
		$blog_id = msls_blog_collection()->get_blog_id( $language );
		if ( $current_site->blog_id != $blog_id ) {
			$option = get_blog_option( $blog_id, 'msls' );
			//error_log( print_r( $option, true ) );
		}

>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		return apply_filters( 'check_url', get_permalink( $post ), $this );
	}

	/**
	 * Get current link
	 *
	 * @return string
	 */
	public function get_current_link(): string {
		return (string) get_permalink( $this->get_arg( 0, 0 ) );
	}

}
