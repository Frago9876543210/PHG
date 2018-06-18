<?php

declare(strict_types=1);

namespace Frago9876543210\PNG;


use Frago9876543210\PNG\chunks\{
	Chunk, IDAT, IEND, IHDR
};

class PNG{
	public const HEADER = "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A";

	/** @var Chunk[] */
	protected $chunks = [];
	/** @var string */
	protected $buffer;

	/**
	 * PNG constructor.
	 * @param int    $width
	 * @param int    $height
	 * @param string $rgba
	 * @param int    $compressionLevel
	 */
	public function __construct(int $width, int $height, string $rgba, int $compressionLevel = 9){
		$IHDR = new IHDR;
		$IHDR->width = $width;
		$IHDR->height = $height;
		$this->appendChunk($IHDR);

		$IDAT = new IDAT;
		$IDAT->compressionLevel = $compressionLevel;
		$IDAT->width = $IHDR->width;
		$IDAT->height = $IHDR->height;
		$IDAT->payload = $rgba;
		$this->appendChunk($IDAT);

		$this->appendChunk(new IEND);
	}

	public function appendChunk(Chunk $chunk) : void{
		$this->chunks[] = $chunk;
	}

	public function __toString() : string{
		$buffer = self::HEADER;
		foreach($this->chunks as $chunk){
			$chunk->encode();
			$buffer .= $chunk->buffer;
		}
		return $buffer;
	}

	public function save(string $filename) : void{
		file_put_contents($filename, (string) $this);
	}
}