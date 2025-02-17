<?php

namespace lloc\MslsTests;

use Brain\Monkey\Functions;
use Brain\Monkey\Filters;
use lloc\Msls\MslsPlugin;
use lloc\Msls\MslsOptions;

class WP_Test_MslsPlugin extends Msls_UnitTestCase {

	public function get_test() {
		global $wpdb;

		$wpdb = \Mockery::mock( \WPDB::class );
		$wpdb->shouldReceive( 'prepare' )->andReturnArg( 0 );
		$wpdb->shouldReceive( 'query' )->andReturn( true );

		$options = \Mockery::mock( MslsOptions::class );
		$options->shouldReceive( 'is_excluded' )->andReturn( false );

		return new MslsPlugin( $options );
	}

<<<<<<< HEAD
	public function test_admin_menu() {
=======
	/**
	 * Verify the static init-method
	 */
	function test_admin_menu(): void {
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		Functions\when( 'wp_enqueue_style' )->returnArg();
		Functions\when( 'plugins_url' )->justReturn( 'https://lloc.de/wp-content/plugins' );

		$this->assertNull( $this->get_test()->admin_menu() );
	}

<<<<<<< HEAD
	public function test_init_widget_true() {
		Functions\expect( 'register_widget' )->once()->andReturn( true );

		$this->assertNull( $this->get_test()->init_widget() );
	}

	public function test_block_render_output() {
		$expected = 'Booh!';

=======
	/**
	 * Verify the static init_widget-method
	 */
	function test_init_widget(): void {
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		Functions\when( 'register_widget' )->justReturn( true );
		Functions\when( 'the_widget' )->justEcho( $expected );

		$this->assertEquals( $expected, $this->get_test()->block_render() );
	}

<<<<<<< HEAD
	public function test_init_i18n_support() {
		Functions\expect( 'load_plugin_textdomain' )->once();
=======
	/**
	 * Verify the static init_i18n_support-method
	 */
	function test_init_i18n_support(): void {
		Functions\when( 'load_plugin_textdomain' )->justReturn( true );
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

		$this->assertNull( $this->get_test()->init_i18n_support() );
	}

<<<<<<< HEAD
	public function test_message_handler() {
=======
	/**
	 * Verify the static message_handler-method
	 */
	function test_message_handler(): void {
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		$this->expectOutputString( '<div id="msls-warning" class="error"><p>Test</p></div>' );

		MslsPlugin::message_handler( 'Test' );
	}

<<<<<<< HEAD
	public function test_uninstall() {
=======
	/**
	 * Verify the static uninstall-method
	 */
	function test_uninstall(): void {
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		Functions\when( 'delete_option' )->justReturn( false );

		$this->assertFalse( $this->get_test()->uninstall() );
	}

<<<<<<< HEAD
	public function test_cleanup_true() {
		Functions\when( 'delete_option' )->justReturn( true );
=======
	/**
	 * Verify the static cleanup-method
	 */
	function test_cleanup(): void {
		Functions\when( 'delete_option' )->justReturn( false );
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

		$this->assertTrue( $this->get_test()->uninstall() );
	}

	public function test_activate() {
		$expected = 'register_unistall_hook called';

		Functions\when( 'register_uninstall_hook' )->justEcho( $expected );

		$this->expectOutputString( $expected );
		MslsPlugin::activate();
	}

	public function test_admin_bar_init_hidden(): void {
		Functions\expect( 'is_admin_bar_showing' )->once()->andReturn( false );

		$this->assertNull( $this->get_test()->admin_bar_init() );
	}

	public function test_admin_bar_init_shown(): void {
		Functions\expect( 'is_admin_bar_showing' )->once()->andReturn( true );
		Functions\expect( 'is_super_admin' )->once()->andReturn( true );

		$this->assertNull( $this->get_test()->admin_bar_init() );
	}

	public function test_block_init_not_excluded() {
		Functions\when( 'plugins_url' )->justReturn( 'https://lloc.de/wp-content/plugins' );

		Functions\expect( 'wp_register_script' )->once();
		Functions\expect( 'register_block_type' )->once();
		Functions\expect( 'add_shortcode' )->once();

		$this->assertNull( $this->get_test()->block_init() );
	}

	public function test_content_filter_front_page() {
		Functions\expect( 'is_front_page' )->once()->andReturn( true );

		$this->assertEquals( '', $this->get_test()->content_filter( '' ) );
	}

	public function test_content_filter_not_singular() {
		Functions\expect( 'is_front_page' )->once()->andReturn( false );
		Functions\expect( 'is_singular' )->once()->andReturn( false );

		$this->assertEquals( '', $this->get_test()->content_filter( '' ) );
	}

	public function test_filter_string_has_filter() {
		Functions\expect( 'get_current_blog_id' )->andReturn( 1 );
		Functions\expect( 'get_users' )->andReturn( [] );
		Functions\expect( 'get_blogs_of_user' )->andReturn( [] );
		Functions\expect( 'has_filter' )->with( 'msls_filter_string' )->andReturn( true );

		$this->get_test()->filter_string();

		$this->assertTrue( Filters\applied( 'msls_filter_string' ) > 0 );
	}

	public function test_filter_string_no_filter() {
		Functions\expect( 'get_current_blog_id' )->andReturn( 1 );
		Functions\expect( 'get_users' )->andReturn( [] );
		Functions\expect( 'get_blogs_of_user' )->andReturn( [] );
		Functions\expect( 'has_filter' )->with( 'msls_filter_string' )->andReturn( false );

		$this->assertEquals( '', $this->get_test()->filter_string() );
	}

	public function test_adminbar() {
		Functions\expect( 'get_site_option' )->andReturn( [] );
		Functions\expect( 'get_blog_option' )->once()->andReturn( [] );

		$adminbar = \Mockery::mock( \WP_Admin_Bar::class );
		$adminbar->shouldReceive( 'add_node' );

		$this->assertEquals( 1, $this->get_test()->update_adminbar( $adminbar ) );
	}

	public function test_print_alternate_links() {
		Functions\expect( 'is_admin' )->once()->andReturn( false );
		Functions\expect( 'is_front_page' )->once()->andReturn( true );
		Functions\expect( 'get_option' )->once()->andReturn( [] );
		Functions\expect( 'home_url' )->once()->andReturn( '/home_url' );

		$this->expectOutputString( '<link rel="alternate" hreflang="x-default" href="/home_url" title="1" />' . PHP_EOL );
		$this->get_test()->print_alternate_links();
	}

	public function test_init_widget_false() {
		$options = \Mockery::mock( MslsOptions::class );
		$options->shouldReceive( 'is_excluded' )->once()->andReturn( true );

		$plugin = new MslsPlugin( $options );

		$this->assertNull( $plugin->init_widget() );
	}

	public function test_block_init_excluded() {
		$options = \Mockery::mock( MslsOptions::class );
		$options->shouldReceive( 'is_excluded' )->once()->andReturn( true );

		$plugin = new MslsPlugin( $options );

		$this->assertNull( $plugin->block_init() );
	}

	public function test_content_filter_singular() {
		Functions\expect( 'is_front_page' )->once()->andReturn( false );
		Functions\expect( 'is_singular' )->once()->andReturn( true );
		Functions\expect( 'get_current_blog_id' )->andReturn( 1 );
		Functions\expect( 'get_users' )->andReturn( [] );
		Functions\expect( 'get_blogs_of_user' )->andReturn( [] );

		$options = \Mockery::mock( MslsOptions::class );
		$options->shouldReceive( 'is_content_filter' )->andReturn( true );

		$plugin = new MslsPlugin( $options );

		$this->assertEquals( '', $plugin->content_filter( '' ) );
	}

}
