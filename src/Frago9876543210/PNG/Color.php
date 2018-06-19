<?php

declare(strict_types=1);

namespace Frago9876543210\PNG;


use pocketmine\utils\Binary;

class Color{
	/** @var int */
	protected $r, $g, $b, $a;

	public function __construct(int $r, int $g, int $b, int $a = 0xff){
		$this->r = $r & 0xff;
		$this->g = $g & 0xff;
		$this->b = $b & 0xff;
		$this->a = $a & 0xff;
	}

	public function getR() : int{
		return $this->r;
	}

	public function setR(int $r) : void{
		$this->r = $r & 0xff;
	}

	public function getG() : int{
		return $this->g;
	}

	public function setG(int $g) : void{
		$this->g = $g & 0xff;
	}

	public function getB() : int{
		return $this->b;
	}

	public function setB(int $b) : void{
		$this->b = $b & 0xff;
	}

	public function getA() : int{
		return $this->a;
	}

	public function setA(int $a) : void{
		$this->a = $a & 0xff;
	}

	public function toRGBA() : int{
		return ($this->r << 24) | ($this->g << 16) | ($this->b << 8) | $this->a;
	}

	public function __toString() : string{
		return Binary::writeInt($this->toRGBA());
	}
}