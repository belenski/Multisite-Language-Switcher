<?php

namespace lloc\Msls;

use lloc\Msls\Settings\PermalinkStructure;
use lloc\Msls\Component\Icon\IconPng;

/**
 * General options class
 *
 * @package Msls
 *
 * @property bool $activate_autocomplete
 * @property bool output_current_blog
 * @property int $display
 * @property int $reference_user
 * @property int $content_priority
 * @property string $admin_display
 * @property string $admin_language
 * @property string $description
 * @property string $before_item
 * @property string $after_item
 * @property string $before_output
 * @property string $after_output
 */
class MslsOptions extends MslsGetSet implements OptionsInterface {

	/**
	 * @var array<int, mixed>
	 */
	protected $args;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var bool
	 */
	protected $exists = false;

	/**
	 * @var string
	 */
	protected $sep = '';

	/**
	 * @var string
	 */
	protected $autoload = 'yes';

	/**
	 * @var array<string, string>
	 */
	private $available_languages;

	/**
	 * @var ?bool
	 */
	public $with_front;

	/**
	 * @codeCoverageIgnore
	 *
	 * @param int $id
	 *
	 * @return MslsOptions
	 */
	public static function create( $id = 0 ) {
		if ( is_admin() ) {
			$id = (int) $id;

			if ( MslsContentTypes::create()->is_taxonomy() ) {
				return MslsOptionsTax::create( $id );
			}

			return new MslsOptionsPost( $id );
		}

		if ( self::is_main_page() ) {
			$options = new MslsOptions();
		} elseif ( self::is_tax_page() ) {
			$options = MslsOptionsTax::create();
		} elseif ( self::is_query_page() ) {
			$options = MslsOptionsQuery::create();
		} else {
			$options = new MslsOptionsPost( get_queried_object_id() );
		}

		add_filter( 'check_url', [ $options, 'check_for_blog_slug' ], 10, 2 );

		return $options;
	}

	/**
	 * Checks if the current page is a home, front or 404 page
	 * @return boolean
	 */
	public static function is_main_page() {
		return is_front_page() || is_search() || is_404();
	}

	/**
	 * Checks if the current page is a category, tag or any other tax archive
	 * @return boolean
	 */
	public static function is_tax_page() {
		return is_category() || is_tag() || is_tax();
	}

	/**
	 * Checks if the current page is a date, author any other post_type archive
	 * @return boolean
	 */
	public static function is_query_page() {
		return is_date() || is_author() || is_post_type_archive();
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->args   = func_get_args();
		$this->name   = 'msls' . $this->sep . implode( $this->sep, $this->args );
		$this->exists = $this->set( get_option( $this->name ) );
	}

	/**
	 * Gets an element of arg by index
	 *
	 * The returning value is cast to the type of $default or will be the
	 * value of $default if nothing is set at this index.
	 *
	 * @param int $index
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get_arg( int $index, $default = null ) {
		$arg = $this->args[ $index ] ?? $default;
		settype( $arg, gettype( $default ) );

		return $arg;
	}

	/**
	 * Save
	 *
	 * @param mixed $arr
	 *
	 * @codeCoverageIgnore
	 */
	public function save( $arr ): void {
		$this->delete();
		if ( $this->set( $arr ) ) {
			$arr = $this->get_arr();
			if ( ! empty( $arr ) ) {
				add_option( $this->name, $arr, '', $this->autoload );
			}
		}
	}

	/**
	 * Delete
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function delete(): void {
		$this->reset();
		if ( $this->exists ) {
			delete_option( $this->name );
		}
	}

	/**
	 * Set
	 *
	 * @param mixed $arr
	 *
	 * @return bool
	 */
	public function set( $arr ) {
		if ( ! is_array( $arr ) ) {
			return false;
		}

		/**
		 * Mapping for us language code
		 */
		$map = [ 'us' => 'en_US', 'en' => 'en_US' ];
		foreach ( $map as $old => $new ) {
			if ( isset( $arr[ $old ] ) ) {
				$arr[ $new ] = $arr[ $old ];
			}
		}

		foreach ( $arr as $key => $value ) {
			$this->__set( $key, $value );
		}

		return true;
	}

	/**
	 * Get permalink
	 *
	 * @param string $language
	 *
	 * @return string
	 */
	public function get_permalink( string $language ): string {
		/**
		 * Filters the url by language
		 * @since 0.9.8
		 *
		 * @param string $postlink
		 * @param string $language
		 */
		$postlink = (string) apply_filters(
			'msls_options_get_permalink',
			$this->get_postlink( $language ),
			$language
		);

		return '' != $postlink ? $postlink : home_url( '/' );
	}

	/**
	 * Get postlink
	 *
	 * @param string $language
	 *
	 * @return string
	 */
	public function get_postlink( string $language ): string {
		return '';
	}

	/**
	 * Get the queried taxonomy
	 * @return string
	 */
	public function get_tax_query(): string {
		return '';
	}

	/**
	 * Get current link
	 * @return string
	 */
	public function get_current_link(): string {
		return home_url( '/' );
	}

	/**
	 * Is excluded
	 * @return bool
	 */
	public function is_excluded(): bool {
		return isset( $this->exclude_current_blog );
	}

	/**
	 * Is content
	 * @return bool
	 */
	public function is_content_filter(): bool {
		return isset( $this->content_filter );
	}

	/**
	 * Get order
	 * @return string
	 */
	public function get_order(): string {
		return  isset( $this->sort_by_description ) ? 'description' : 'language';
	}

	/**
	 * Get url
	 *
	 * @param string $dir
	 *
	 * @return string
	 */
	public function get_url( string $dir ): string {
		return esc_url( MslsPlugin::plugins_url( $dir ) );
	}

	/**
	 * @param string $language
	 *
	 * @return string
	 */
	public function get_icon( string $language ): string {
		return ( new IconPng() )->get( $language );
	}

	/**
	 * Get flag url
	 *
	 * @param string $language
	 *
	 * @return string
	 */
	public function get_flag_url( string $language ): string {
		if ( ! is_admin() && isset( $this->image_url ) ) {
			$url = $this->__get( 'image_url' );
		} else {
			$url = $this->get_url( 'flags' );
		}

		/**
		 * Override the path to the flag-icons
		 * @since 0.9.9
		 *
		 * @param string $url
		 */
		$url = (string) apply_filters( 'msls_options_get_flag_url', $url );

		$icon = $this->get_icon( $language );

		/**
		 * Use your own filename for the flag-icon
		 * @since 1.0.3
		 *
		 * @param string $icon
		 * @param string $language
		 */
		$icon = (string) apply_filters( 'msls_options_get_flag_icon', $icon, $language );

		return sprintf( '%s/%s', $url, $icon );
	}

	/**
	 * Get all available languages
	 *
	 * @uses get_available_languages
	 * @uses format_code_lang
	 *
	 * @return array<string, string>
	 */
	public function get_available_languages(): array {
		if ( empty( $this->available_languages ) ) {
			$this->available_languages = [
				'en_US' => __( 'American English', 'multisite-language-switcher' ),
			];

			foreach ( get_available_languages() as $code ) {
				$this->available_languages[ esc_attr( $code ) ] = format_code_lang( $code );
			}

			/**
			 * Returns custom filtered available languages
			 * @since 1.0
			 *
			 * @param array $available_languages
			 */
			$this->available_languages = (array) apply_filters(
				'msls_options_get_available_languages',
				$this->available_languages
			);
		}

		return $this->available_languages;
	}

	/**
	 * The 'blog'-slug-problem :/
	 *
	 * @param string $url
	 * @param MslsOptions $options
	 *
	 * @return string
	 */
	public static function check_for_blog_slug( $url, $options ): string {
		if ( empty( $url ) || ! is_string( $url ) ) {
			return '';
		}

		global $wp_rewrite;
		if ( ! is_subdomain_install() || ! $wp_rewrite->using_permalinks() ) {
			return $url;
		}

		global $current_site;

		return ( new PermalinkStructure( $current_site->blog_id ) )->get_home_url( $url, $options->with_front );
	}

	/**
	 * Get the icon type by the settings saved in admin_display
	 *
	 * @return string
	 */
	public function get_icon_type(): string {
		return MslsAdminIcon::TYPE_LABEL === $this->admin_display ? MslsAdminIcon::TYPE_LABEL : MslsAdminIcon::TYPE_FLAG;
	}

}
