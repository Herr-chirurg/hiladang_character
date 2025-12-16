<?php

namespace App\Service;

use App\Entity\Scenario;
use App\Entity\Token;

class WBLService {

	private array $levelData;
	private array $scenarioData;
	private float $coeff_gv = 1.25;

	public function __construct()
    { 
		$this->scenarioData = [
			3  => [1000, 	1125],
			4  => [1500, 	1406],
			5  => [1600, 	1375],
			6  => [2400, 	1875],
			7  => [2667, 	1979],
			8  => [4000, 	2708],
			9  => [4286, 	2857],
			10 => [6250, 	3125],
			11 => [7222, 	3611],
			12 => [9500,   	4000],
			13 => [13000,  	5625],
			14 => [19000,  	6875],
			15 => [25500,  	9375],
			16 => [41000,  	11875],
			17 => [50000,  	15000],
			18 => [75000,  	19375],
			19 => [105000, 	24375],
		];

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

	public function levelToMinGP(?int $level): int 
	{
		return $this->levelData[$level][1] * $this->coeff_gv;
	}

	public function currentXPToLevelUp(?int $level): int {

		return $this->levelToMinXP($level+1) - $this->levelToMinXP($level);
	}

	public function levelAndXPToGV(?int $level, string $currentXp): int 
	{
		return ($this->levelData[$level][1] + $currentXp/$this->levelData[$level][2]) * $this->coeff_gv;
	}

	public function rewardExtraPR(?int $scenarioLevel, ?int $level) {
		return ($scenarioLevel - $level) * 25;
	}

	//
	public function xpToRate(?int $level, ?int $xp) {
		return ($xp / $this->scenarioData[$level][0]) * 100;
	}

	public function rateToXp(?int $level, ?int $rate) {
		return $this->scenarioData[$level][0] * ($rate/100);
	}

	public function rateToGp(?int $level, ?int $rate) {
		return $this->scenarioData[$level][1] * ($rate/100);
	}
}