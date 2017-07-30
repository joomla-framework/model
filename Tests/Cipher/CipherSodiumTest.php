<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Crypt\Tests;

use Joomla\Crypt\Cipher_Sodium;
use Joomla\Crypt\Crypt;
use ParagonIE\Sodium\Compat;
use PHPUnit\Framework\TestCase;
use Symfony\Polyfill\Util\Binary;

/**
 * Test class for \Joomla\Crypt\Cipher_Sodium.
 */
class CipherSodiumTest extends TestCase
{
	/**
	 * Prepares the environment before running a test.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		// The real class can't be autoloaded
		require_once __DIR__ . '/../../Cipher/Sodium.php';

		parent::setUp();
	}

	/**
	 * Test data for processing
	 *
	 * @return  array
	 */
	public function dataStrings()
	{
		return array(
			array('c-;3-(Is>{DJzOHMCv_<#yKuN/G`/Us{GkgicWG$M|HW;kI0BVZ^|FY/"Obt53?PNaWwhmRtH;lWkWE4vlG5CIFA!abu&F=Xo#Qw}gAp3;GL\'k])%D}C+W&ne6_F$3P5'),
			array('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ' .
					'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor ' .
					'in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt ' .
					'in culpa qui officia deserunt mollit anim id est laborum.'),
			array('لا أحد يحب الألم بذاته، يسعى ورائه أو يبتغيه، ببساطة لأنه الألم...'),
			array('Широкая электрификация южных губерний даст мощный толчок подъёму сельского хозяйства'),
			array('The quick brown fox jumps over the lazy dog.')
		);
	}

	/**
	 * @testdox  Validates data is encrypted and decrypted correctly
	 *
	 * @param   string  $data  The decrypted data to validate
	 *
	 * @covers        Cipher_Sodium::decrypt
	 * @covers        Cipher_Sodium::encrypt
	 * @dataProvider  dataStrings
	 */
	public function testDataEncryptionAndDecryption($data)
	{
		$cipher = new Cipher_Sodium;
		$key    = $cipher->generateKey();

		$cipher->setNonce(Compat::randombytes_buf(Compat::CRYPTO_BOX_NONCEBYTES));

		$encrypted = $cipher->encrypt($data, $key);

		// Assert that the encrypted value is not the same as the clear text value.
		$this->assertNotSame($data, $encrypted);

		$decrypted = $cipher->decrypt($encrypted, $key);

		// Assert the decrypted string is the same value we started with
		$this->assertSame($data, $decrypted);
	}

	/**
	 * @testdox  Validates keys are correctly generated
	 *
	 * @covers   Cipher_Sodium::generateKey
	 */
	public function testGenerateKey()
	{
		$cipher = new Cipher_Sodium;
		$key    = $cipher->generateKey();

		// Assert that the key is the correct type.
		$this->assertInstanceOf('Joomla\\Crypt\\Key', $key);

		// Assert the keys pass validation
		$this->assertSame(Binary::strlen($key->private), 32);
		$this->assertSame(Binary::strlen($key->public), 32);

		// Assert the key is of the correct type.
		$this->assertAttributeEquals('sodium', 'type', $key);
	}
}
