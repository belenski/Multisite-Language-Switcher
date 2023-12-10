<?php

namespace lloc\MslsTests;

<<<<<<< HEAD
use Brain\Monkey\Functions;
=======
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
use lloc\Msls\MslsBlog;
use lloc\Msls\MslsCustomColumn;
use lloc\Msls\MslsOptions;
use lloc\Msls\MslsBlogCollection;
use Brain\Monkey\Functions;

class WP_Test_MslsCustomColumn extends Msls_UnitTestCase {

<<<<<<< HEAD
	public function setUp(): void {
		parent::setUp();

		Functions\stubs( [
			'get_current_blog_id'  => 1,
			'get_blog_option'      => 'de_DE',
			'add_query_arg'        => '/query',
			'get_the_ID'           => 1,
			'plugin_dir_path'      => dirname( __DIR__, 1 ) . '/',
			'is_admin'             => true,
			'get_option'           => [ 'de_DE' => 1, 'en_US' => 42 ],
			'switch_to_blog'       => true,
			'restore_current_blog' => true,
			'get_post_types'       => [],
			'get_admin_url'        => '/admin_url',
			'get_edit_post_link' => '/temp',
		] );
	}

	public function get_sut(): MslsCustomColumn {
		$map = [ 'de_DE', 'en_US' ];

		$blogs = [];
		foreach ( $map as $locale ) {
			$blog = \Mockery::mock( MslsBlog::class );
			$blog->shouldReceive( [ 'get_language' => $locale ] );
=======
	function test_th() {
		Functions\expect( 'add_query_arg' )->twice()->andReturn( 'https://example.org/added-args' );
		Functions\expect( 'get_the_ID' )->twice()->andReturnValues( [ 1, 2 ] );
		Functions\when( 'plugin_dir_path' )->justReturn( dirname( __DIR__, 1 ) . '/' );

		$options  = \Mockery::mock( MslsOptions::class );

		foreach (  [ 'de_DE' => 'de', 'en_US' => 'en' ] as $locale => $alpha2 ) {
			$blog = \Mockery::mock( MslsBlog::class );
			$blog->shouldReceive( [
				'get_alpha2'   => $alpha2,
				'get_language' => $locale,
			] );
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

			$blogs[] = $blog;
		}

<<<<<<< HEAD
		$options = \Mockery::mock( MslsOptions::class );
=======
		$collection = \Mockery::mock( MslsBlogCollection::class );
		$collection->shouldReceive( 'get_objects' )->andReturn( $blogs );
		$collection->shouldReceive( 'get' )->andReturn( $blogs );
		$collection->shouldReceive( 'get_current_blog_id' )->andReturn( 1 );

		$obj      = new MslsCustomColumn( $options, $collection );
		$expected = [ 'mslscol' => '<span class="msls-icon-wrapper "><span class="flag-icon flag-icon-de">de_DE</span></span><span class="msls-icon-wrapper "><span class="flag-icon flag-icon-us">en_US</span></span>' ];

		$this->assertEquals( $expected, $obj->th( [] ) );
	}

	function test_th_empty() {
		$options    = \Mockery::mock( MslsOptions::class );
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

		$collection = \Mockery::mock( MslsBlogCollection::class );
		$collection->shouldReceive( 'get' )->andReturn( $blogs );

		return new MslsCustomColumn( $options, $collection );
	}

	public function test_th(): void {
		$expected = [ 'mslscol' => '<span class="flag-icon flag-icon-de">de_DE</span>&nbsp;<span class="flag-icon flag-icon-us">en_US</span>' ];

		$test = $this->get_sut();

		$this->assertEquals( $expected, $test->th( [] ) );
	}

	public function test_td(): void {
		$expected = '<a title="Edit the translation in the de_DE-blog" href="/temp"><span class="dashicons dashicons-edit"></span></a>&nbsp;<a title="Edit the translation in the en_US-blog" href="/temp"><span class="dashicons dashicons-edit"></span></a>&nbsp;';

		$test = $this->get_sut();

		$this->expectOutputString( $expected );

		$test->td( 'mslscol', 1 );
	}

	public function test_th_no_blogs(): void {
		$options = \Mockery::mock( MslsOptions::class );

		$collection = \Mockery::mock( MslsBlogCollection::class );
		$collection->shouldReceive( 'get' )->andReturn( [] );

		$test = new MslsCustomColumn( $options, $collection );

		$this->assertEmpty( $test->th( [] ) );
	}

	public function test_td_no_blogs(): void {
		$options = \Mockery::mock( MslsOptions::class );

		$collection = \Mockery::mock( MslsBlogCollection::class );
		$collection->shouldReceive( 'get' )->andReturn( [] );

		$test = new MslsCustomColumn( $options, $collection );

		$expected = '';

		$this->expectOutputString( $expected );

		$test->td( 'mslscol', 1 );
	}

}
