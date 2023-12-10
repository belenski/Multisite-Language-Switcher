<?php

namespace lloc\MslsTests;

use lloc\Msls\MslsBlogCollection;
use lloc\Msls\MslsCustomColumnTaxonomy;
use lloc\Msls\MslsOptions;

class WP_Test_MslsCustomColumnTaxonomy extends Msls_UnitTestCase {

	public function test_th(): void {
		$options    = \Mockery::mock( MslsOptions::class );

		$collection = \Mockery::mock( MslsBlogCollection::class );
<<<<<<< HEAD
		$collection->shouldReceive( 'get' )->andReturn( [] );
=======
		$collection->shouldReceive( 'get' )->andReturn( [] )->once();
>>>>>>> 1e85669dfd420a0d77cd57272e937aeb8810393c

		$obj = new MslsCustomColumnTaxonomy( $options, $collection );

		$this->assertEmpty( $obj->th( [] ) );

		$this->expectOutputString( '' );
		$obj->column_default( '', 'test', 1 );
	}

	public function test_column_default(): void {
		$options    = \Mockery::mock( MslsOptions::class );

		$collection = \Mockery::mock( MslsBlogCollection::class );

		( new MslsCustomColumnTaxonomy( $options, $collection ) )->column_default( '', 'test', 0 );

		$this->expectOutputString( '' );
	}

}
