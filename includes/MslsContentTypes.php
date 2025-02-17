<?php

namespace lloc\Msls;

/**
 * Supported content types
 *
 * @package Msls
 */
abstract class MslsContentTypes extends MslsRegistryInstance {

	/**
	 * Request
	 * @var string
	 */
	protected $request;

	/**
	 * Types
	 * @var array<string, mixed>
	 */
	protected $types = [];

	/**
	 * Factory method
	 *
	 * @codeCoverageIgnoreMslsContentTypes
	 *
	 * @return MslsContentTypes
	 */
	public static function create(): MslsContentTypes {
		$_request = MslsPlugin::get_superglobals( [ 'taxonomy' ] );

		return '' != $_request['taxonomy'] ? MslsTaxonomy::instance() : MslsPostType::instance();
	}

	/**
	 * Check for post_type
	 * @return bool
	 */
	public function is_post_type(): bool {
		return false;
	}

	/**
	 * Check for taxonomy
	 * @return bool
	 */
	public function is_taxonomy(): bool {
		return false;
	}

	/**
	 * Check if the current user can manage this content type
	 *
	 * Returns name of the content type if the user has access or an empty
	 * string if the user can not access
	 *
	 * @return string
	 */
	public function acl_request(): string {
		return '';
	}

	/**
	 * Getter
	 *
	 * @return array<string,mixed>
	 */
	abstract public static function get(): array;

	/**
	 * Gets the request if it is an allowed content type
	 *
	 * @return string
	 */
	abstract public function get_request(): string;

}
