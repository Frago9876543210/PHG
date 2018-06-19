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
	/** @var int */
	protected $width;
	/** @var int */
	protected $height;
	/** @var int */
	protected $compressionLevel;
	/** @var Color[][] */
	protected $colors = [];
	/** @var string */
	public $rgba = "";

	/**
	 * PNG constructor.
	 * @param int $width
	 * @param int $height
	 * @param int $compressionLevel
	 */
	public function __construct(int $width, int $height, int $compressionLevel = 9){
		$this->width = $width;
		$this->height = $height;
		$this->compressionLevel = $compressionLevel;
	}

	public function getWidth() : int{
		return $this->width;
	}

	public function getHeight() : int{
		return $this->height;
	}

	public function buildImage() : void{
		$this->buildIHDR();
		if(!empty($this->colors)){
			$this->toRGBAString();
		}
		$this->buildIDAT();
		$this->buildIEND();
	}

	protected function buildIHDR() : void{
		$IHDR = new IHDR;
		$IHDR->width = $this->width;
		$IHDR->height = $this->height;
		$this->appendChunk($IHDR);
	}

	protected function buildIDAT() : void{
		$IDAT = new IDAT;
		$IDAT->compressionLevel = $this->compressionLevel;
		$IDAT->width = $this->width;
		$IDAT->height = $this->height;
		$IDAT->payload = $this->rgba;
		$this->appendChunk($IDAT);
	}

	protected function buildIEND() : void{
		$this->appendChunk(new IEND);
	}

	public function appendChunk(Chunk $chunk) : void{
		$this->chunks[] = $chunk;
	}

	public function setPixel(int $x, int $y, Color $color) : void{
		$this->colors[$y][$x] = $color;
	}

	protected function toRGBAString() : void{
		for($y = 0; $y < $this->height; ++$y){
			for($x = 0; $x < $this->width; ++$x){
				$this->rgba .= (string) $this->colors[$y][$x];
			}
		}
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