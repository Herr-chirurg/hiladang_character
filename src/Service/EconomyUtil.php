<?php

namespace App\Service;

class EconomyUtil {

	private array $levelData;
	private float $coeff_gv = 1.25;

	public function __construct()
    { 
		$this->levelData = [
            1 	=> [0, 			0, 		0.00],
			2 	=> [2000, 		1000, 	2.00],
			3 	=> [5000, 		3000, 	1.50],
			4 	=> [9000, 		6000, 	1.33],
			5 	=> [15000, 		10500, 	1.33],
			6 	=> [23000, 		16000, 	1.45],
			7 	=> [35000, 		23500, 	1.60],
			8 	=> [51000, 		33000, 	1.68],
			9 	=> [75000, 		46000, 	1.85],
			10 	=> [105000, 	62000, 	1.88],
			11 	=> [155000, 	82000, 	2.50],
			12 	=> [220000, 	108000,	2.50],
			13 	=> [315000, 	140000,	2.97],
			14 	=> [445000, 	185000, 2.89],
			15 	=> [635000, 	240000, 3.45],
			16 	=> [890000, 	315000, 3.40],
			17 	=> [1300000, 	410000, 4.32],
			18 	=> [1800000, 	530000, 4.17],
			19 	=> [2550000, 	685000, 4.84],
			20 	=> [3600000, 	880000, 5.38],
		];
	}

	public function levelToMinXP(?int $level): int 
	{
		return $this->levelData[$level][0];
	}

	public function levelAndXPToGV(?int $level, string $xp): int 
	{
		return ($this->levelData[$level][1] + $this->levelData[$level][2] * $xp) * $this->coeff_gv;
	}

}