<?php

declare(strict_types=1);

namespace Frago9876543210\PNG\chunks;


class IDAT extends Chunk{
	/** @var int */
	public $compressionLevel = 9;
	/** @var string */
	public $payload;
	/** @var int */
	public $width;
	/** @var int */
	public $height;

	protected function encodeContent() : void{
		$array = str_split($this->payload, $this->width * 4);
		for($i = 0; $i < $this->height; $i++){
			$array[$i] = "\x00" . $array[$i];
		}
		$this->content->put(zlib_encode(implode("", $array), ZLIB_ENCODING_DEFLATE, $this->compressionLevel));
	}

	protected function decodeContent() : void{
		// TODO: Implement decodeContent() method.
	}

	public function getName() : string{
		return "IDAT";
	}
}