<?php

declare(strict_types=1);

namespace Frago9876543210\PNG\chunks;


class IEND extends Chunk{

	protected function encodeContent() : void{
	}

	protected function decodeContent() : void{
	}

	public function getName() : string{
		return "IEND";
	}
}