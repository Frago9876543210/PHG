<?php

declare(strict_types=1);

namespace Frago9876543210\PNG\chunks;


class IHDR extends Chunk{
	/** @var int */
	public $length = 13;
	/** @var int */
	public $width;
	/** @var int */
	public $height;
	/** @var int */
	public $bitDepth = 8;
	/** @var int */
	public $colorType = 6;
	/** @var int */
	public $compressionMethod = 0;
	/** @var int */
	public $filterMethod = 0;
	/** @var int */
	public $interlaceMethod = 0;

	protected function encodeContent() : void{
		$this->content->putInt($this->width);
		$this->content->putInt($this->height);
		$this->content->putByte($this->bitDepth);
		$this->content->putByte($this->colorType);
		$this->content->putByte($this->compressionMethod);
		$this->content->putByte($this->filterMethod);
		$this->content->putByte($this->interlaceMethod);
	}

	protected function decodeContent() : void{
		// TODO: Implement decodeContent() method.
	}

	public function getName() : string{
		return "IHDR";
	}
}