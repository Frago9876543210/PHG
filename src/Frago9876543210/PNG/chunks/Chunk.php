<?php

declare(strict_types=1);

namespace Frago9876543210\PNG\chunks;


use pocketmine\utils\BinaryStream;

abstract class Chunk extends BinaryStream{
	/** @var int */
	public $length;
	/** @var BinaryStream $content */
	public $content;

	public function __construct(string $buffer = "", int $offset = 0){
		parent::__construct($buffer, $offset);
		$this->content = new BinaryStream;
	}

	public function encode() : void{
		$this->reset();

		$this->encodeContent();

		$this->putInt(strlen($this->content->buffer));
		$this->put($this->getName());
		$this->put($this->content->buffer);
		$this->putInt($this->calculateChecksum());
	}

	public function decode() : void{
		$this->length = $this->getInt();
		$this->offset += 4;
		$this->content = new BinaryStream($this->get($this->length));
		$this->decodeContent();
		$this->getInt();
	}

	public function calculateChecksum() : int{
		return crc32($this->getName() . $this->content->buffer);
	}

	abstract protected function encodeContent() : void;

	abstract protected function decodeContent() : void;

	abstract public function getName() : string;

	public function isUpperCase(string $char, int $index) : bool{
		//for example: A = 1000001, a = 1100001. This is also true for other letters
		return (ord($char{$index}) & 32) === 0;
	}

	/**
	 * More info about chunk naming conventions:
	 * @link https://tools.ietf.org/html/rfc2083#page-12
	 *
	 * 0 (uppercase) = critical, 1 (lowercase) = ancillary.
	 * @return bool
	 */
	public function isCritical() : bool{
		return $this->isUpperCase($this->getName(), 0);
	}


	/**
	 * 0 (uppercase) = public, 1 (lowercase) = private.
	 * @return bool
	 */
	public function isPublic() : bool{
		return $this->isUpperCase($this->getName(), 1);
	}

	/*
	 * Reserved bit: bit 5 of third byte
	 * Must be 0 (uppercase) in files conforming to this version of PNG.
	 */

	/**
	 * 0 (uppercase) = unsafe to copy, 1 (lowercase) = safe to copy.
	 * @return bool
	 */
	public function isSafeToCopy() : bool{
		return $this->isUpperCase($this->getName(), 3);
	}
}