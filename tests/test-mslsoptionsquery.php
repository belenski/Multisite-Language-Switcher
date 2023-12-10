<?php

namespace lloc\MslsTests;

use Brain\Monkey\Functions;

use lloc\Msls\MslsOptionsQuery;

/**
 * WP_Test_MslsOptionsQuery
 */
class WP_Test_MslsOptionsQuery extends Msls_UnitTestCase {

<<<<<<< HEAD
	public function test_get_current_link_method(): void {
=======
	public function test_create(): void {
		Functions\expect( 'is_day' )->once()->andReturn( false );
		Functions\expect( 'is_month' )->once()->andReturn( false );
		Functions\expect( 'is_year' )->once()->andReturn( false );
		Functions\expect( 'is_author' )->once()->andReturn( false );
		Functions\expect( 'is_post_type_archive' )->once()->andReturn( false );

		$this->assertNull( MslsOptionsQuery::create() );
	}

	public function test_current_get_postlink(): void {
		$home_url = 'https://example.org/';

		Functions\expect( 'get_option' )->once()->andReturn( [ 'de_DE' => 42 ] );
		Functions\expect( 'home_url' )->once()->andReturn( $home_url );

		$this->assertEquals( $home_url, ( new MslsOptionsQuery() )->get_postlink( 'de_DE' ) );
	}

	public function test_non_existent_get_postlink(): void {
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
		Functions\expect( 'get_option' )->once()->andReturn( [ 'de_DE' => 42 ] );
		Functions\expect( 'home_url' )->once()->andReturnFirstArg();

<<<<<<< HEAD
		$sut = new MslsOptionsQuery();

		$this->assertEquals( '/', $sut->get_current_link() );
	}

	public function test_get_existing_postlink() {
		Functions\expect( 'get_option' )->once()->andReturn( [ 'de_DE' => 42 ] );
		Functions\expect( 'home_url' )->once()->andReturnFirstArg();

		$sut = new MslsOptionsQuery();

		$this->assertEquals( '/', $sut->get_postlink( 'de_DE' ) );
	}

	public function test_get_non_existing_postlink() {
		Functions\expect( 'get_option' )->once()->andReturn( [ 'de_DE' => 42 ] );

		$sut = new MslsOptionsQuery();

		$this->assertEquals( '', $sut->get_postlink( 'it_IT' ) );
	}

}
=======
		$this->assertEquals( '', ( new MslsOptionsQuery() )->get_postlink( 'fr_FR' ) );
	}

}
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c
