<?php

namespace lloc\Msls;

/**
 * OptionsQueryPostType
 *
 * @package Msls
 */
class MslsOptionsQueryPostType extends MslsOptionsQuery {

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
<<<<<<< HEAD
			$this->arr[ $key ] = get_post_type_object( $this->get_post_type() );
		}

		return boolval( $this->arr[ $key ] );
=======
			$this->arr[ $key ] = get_post_type_object( $this->get_arg( 0, '' ) );
		}
		return (bool) $this->arr[ $key ];
>>>>>>> 1267d6b3 (MslsAdmin issues - found by code analyzer - resolved)
=======
			$this->arr[ $key ] = get_post_type_object( $this->get_post_type() );
		}

		return boolval( $this->arr[ $key ] );
>>>>>>> 8eb28d34 (MslsOptionsQuery objects refactored)
	}

	/**
	 * Get current link
	 *
	 * @return string
	 */
	public function get_current_link(): string {
		return strval( get_post_type_archive_link( $this->get_post_type() ) );
	}

	/**
	 * @return string
	 */
	public function get_post_type(): string {
		return $this->get_arg( 0, '' );
	}

}
