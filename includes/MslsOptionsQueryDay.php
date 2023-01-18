<?php

namespace lloc\Msls;

use DateTime;

/**
 * OptionsQueryDay
 *
 * @package Msls
 */
class MslsOptionsQueryDay extends MslsOptionsQuery {

	/**
	 * Check if the array has a non-empty item which has $language as a key
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has_value( string $key ): bool {
		if ( ! isset( $this->arr[ $key ] ) ) {
<<<<<<< HEAD
			$args = [
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
				'date_query'     => $this->get_date_query(),
			];

			$this->arr[ $key ] = ( new PostQuery( $args ) )->has_posts();
		}

		return boolval( $this->arr[ $key ] );
=======
			$date  = new DateTime();
			$cache = MslsSqlCacher::init( __CLASS__ )->set_params( $this->args );

			$this->arr[ $key ] = $cache->get_var(
				$cache->prepare(
					"SELECT count(ID) FROM {$cache->posts} WHERE DATE(post_date) = %s AND post_status = 'publish'",
					$date->setDate( $this->get_arg( 0, 0 ), $this->get_arg( 1, 0 ), $this->get_arg( 2, 0 ) )->format( 'Y-m-d' )
				)
			);
		}

		return (bool) $this->arr[ $key ];
>>>>>>> 1267d6b3 (MslsAdmin issues - found by code analyzer - resolved)
	}

	/**
	 * Get current link
	 *
	 * @return string
	 */
	public function get_current_link(): string {
		$date_query = $this->get_date_query();

		return get_day_link( $date_query['year'], $date_query['month'], $date_query['day'] );
	}

	/**
	 * @return array<string, int>
	 */
	public function get_date_query(): array {
		return [
			'year'  => $this->get_arg( 0, 0 ),
			'month' => $this->get_arg( 1, 0 ),
			'day'   => $this->get_arg( 2, 0 ),
		];
	}

}
