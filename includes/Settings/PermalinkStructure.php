<?php

namespace lloc\Msls\Settings;

use lloc\Msls\MslsOptions;

class PermalinkStructure extends BlogOption {

	/**
	 * @var string
	 */
	protected $option_name = 'permalink_structure';

	/**
	 * @var mixed
	 */
	protected $default = false;

	/**
	 * @param string $url
	 * @param bool $with_front
	 *
	 * @return string
	 */
	public function get_home_url( string $url, bool $with_front = false ): string {
		if ( ! $this->option || ( is_main_site() && $with_front ) ) {
			return $url;
		}

		$url = str_replace( home_url(), '', $url );

		list( $needle, ) = explode( '/%', $this->option, 2 );

		$url = str_replace( $needle, '', $url );

		return home_url( $url );
	}

}