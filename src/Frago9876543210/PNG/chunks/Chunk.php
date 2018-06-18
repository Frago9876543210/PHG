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
}