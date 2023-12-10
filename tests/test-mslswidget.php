<?php

namespace lloc\MslsTests;

use Brain\Monkey\Functions;

use lloc\Msls\MslsBlogCollection;
use lloc\Msls\MslsWidget;

class WP_Test_MslsWidget extends Msls_UnitTestCase {

	public function setUp(): void {
		parent::setUp();
<<<<<<< HEAD

		$arr = [
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		];

		Functions\stubs( [
			'wp_parse_args'       => $arr,
			'get_option'          => [],
			'get_current_blog_id' => 1,
			'get_blogs_of_user'   => [],
			'get_users'           => [],
		] );
	}

	public function get_sut() {
		\Mockery::mock( '\WP_Widget' );

		$widget = \Mockery::mock( MslsWidget::class )->makePartial();
		$widget->shouldReceive( 'get_field_name' )->andReturn( 'test_field_name' );
		$widget->shouldReceive( 'get_field_id' )->andReturn( 'test_field_id' );

		return $widget;
	}

<<<<<<< HEAD
	function test_widget(): void {
		$expected = '<div><h3>Test</h3>No available translations found</div>';

		$this->expectOutputString( $expected );

		$this->get_sut()->widget( [], [ 'title' => 'Test' ] );
	}

=======
=======
	function test_widget() {
		$collection = \Mockery::mock( MslsBlogCollection::class );
		$collection->shouldReceive( 'get_filtered' )->once()->andReturn( [] );
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

		$arr = [
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		];

<<<<<<< HEAD
		Functions\stubs( [
			'wp_parse_args'       => $arr,
			'get_option'          => [],
			'get_current_blog_id' => 1,
			'get_blogs_of_user'   => [],
			'get_users'           => [],
		] );
	}

	public function get_sut() {
		Mockery::mock( '\WP_Widget' );

		$widget = Mockery::mock( MslsWidget::class )->makePartial();
		$widget->shouldReceive( 'get_field_name' )->andReturn( 'test_field_name' );
		$widget->shouldReceive( 'get_field_id' )->andReturn( 'test_field_id' );

		return $widget;
	}

	function test_widget(): void {
		$expected = '<div><h3>Test</h3>No available translations found</div>';

		$this->expectOutputString( $expected );

		$this->get_sut()->widget( [], [ 'title' => 'Test' ] );
	}

>>>>>>> 0190c8e6 (MslsWidget class fully tested)
	function test_update_empty_empty(): void {
		$result = $this->get_sut()->update( [], [] );
=======
		Functions\expect( 'wp_parse_args' )->once()->andReturn( $arr );
		Functions\expect( 'get_option' )->andReturn( [] );
		Functions\expect( 'msls_blog_collection' )->once()->andReturn( $collection );

		$obj = $this->get_sut();

		$this->expectOutputString( '<div><h3>Test</h3>No available translations found</div>' );
		$obj->widget( [], [ 'title' => 'Test' ] );
	}

	function test_update() {
		$obj = $this->get_sut();
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

		$this->assertEquals( [], $result );
	}

	function test_update_string_empty(): void {
		$result = $this->get_sut()->update( [ 'title' => 'Test' ], [] );

		$this->assertEquals( [ 'title' => 'Test' ], $result );
	}

	function test_update_string_string(): void {
		$result = $this->get_sut()->update( [ 'title' => 'xyz' ], [ 'title' => 'Test' ] );

		$this->assertEquals( [ 'title' => 'xyz' ], $result );
	}

	function test_form(): void {
		$expected = '<p><label for="test_field_id">Title:</label> <input class="widefat" id="test_field_id" name="test_field_name" type="text" value="" /></p>';

		$this->expectOutputString( $expected );

<<<<<<< HEAD
		$this->assertEquals( 'mslsform', $this->get_sut()->form( [] ) );
=======
		$this->get_sut()->form( [] );
>>>>>>> 0190c8e6 (MslsWidget class fully tested)
	}

}
