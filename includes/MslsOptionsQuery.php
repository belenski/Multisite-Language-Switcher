<?php

namespace lloc\Msls;


/**
 * OptionsQuery
 *
 * @package Msls
 */
class MslsOptionsQuery extends MslsOptions {

	/**
	 * Rewrite with front
	 * @var bool
	 */
	public $with_front = true;

	/**
	 * Factory method
	 *
	 * @param int $id This parameter is unused here
	 *
	 * @return MslsOptionsQuery|null
	 */
	public static function create( $id = 0 ) {
		$query = null;

		if ( is_day() ) {
			$query = new MslsOptionsQueryDay(
				get_query_var( 'year' ),
				get_query_var( 'monthnum' ),
				get_query_var( 'day' )
			);
		}
		elseif ( is_month() ) {
			$query =  new MslsOptionsQueryMonth(
				get_query_var( 'year' ),
				get_query_var( 'monthnum' )
			);
		}
		elseif ( is_year() ) {
			$query =  new MslsOptionsQueryYear( get_query_var( 'year' ) );
		}
		elseif ( is_author() ) {
			$query =  new MslsOptionsQueryAuthor( get_queried_object_id() );
		}
<<<<<<< HEAD

		return new MslsOptionsQueryPostType(
			get_query_var( 'post_type' )
		);
=======
		elseif ( is_post_type_archive() ) {
			$query =  new MslsOptionsQueryPostType( get_query_var( 'post_type' ) );
		}

		return $query;
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
	}

	/**
	 * Get postlink
	 *
	 * @param string $language
	 *
	 * @return string
	 */
	public function get_postlink( string $language ): string {
		if ( $this->has_value( $language ) ) {
			$link = $this->get_current_link();
			if ( ! empty( $link ) ) {
				return apply_filters( 'check_url', $link, $this );
			}
		}

		return '';
	}

}
