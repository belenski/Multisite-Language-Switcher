<?php

namespace lloc\MslsTests;

use Brain\Monkey\Functions;
use Brain\Monkey\Filters;

use lloc\Msls\Map\HrefLang;
use lloc\Msls\MslsBlog;
use lloc\Msls\MslsBlogCollection;
use Mockery;

class WP_Test_HrefLang extends Msls_UnitTestCase {

	public function get_sut() {
		$map = [
			'de_DE'        => 'de',
			'de_DE_formal' => 'de',
			'fr_FR'        => 'fr',
			'es_ES'        => 'es',
			'cat'          => 'cat',
			'en_US'        => 'en',
			'en_GB'        => 'en',
		];

		foreach ( $map as $locale => $alpha2 ) {
			$blog = Mockery::mock( MslsBlog::class );
			$blog->shouldReceive( [
				'get_alpha2'   => $alpha2,
				'get_language' => $locale,
			] );

			$blogs[] = $blog;
		}

		$collection = Mockery::mock( MslsBlogCollection::class );
		$collection->shouldReceive( 'get_objects' )->andReturn( $blogs );

		return new HrefLang( $collection );
	}

	public function test_get() {
		$obj = $this->get_sut();

		$this->assertEquals( 'de-DE', $obj->get( 'de_DE' ) );
		$this->assertEquals( 'de-DE', $obj->get( 'de_DE_formal' ) );
		$this->assertEquals( 'fr', $obj->get( 'fr_FR' ) );
		$this->assertEquals( 'es', $obj->get( 'es_ES' ) );
		$this->assertEquals( 'cat', $obj->get( 'cat' ) );
		$this->assertEquals( 'en-GB', $obj->get( 'en_GB' ) );
		$this->assertEquals( 'en-US', $obj->get( 'en_US' ) );
	}

	public function test_get_has_filter() {
		$obj = $this->get_sut();

		Functions\when( 'has_filter' )->justReturn( true );
		Filters\expectApplied('msls_head_hreflang')->once()->with( 'en_US')->andReturn( 'en-US' );

		$this->assertEquals( 'en-US', $obj->get( 'en_US' ) );
	}

}
