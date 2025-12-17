<?php

namespace App\Service;

use App\Entity\Scenario;
use App\Entity\Token;

class WBLService {

	private array $levelData;
	private array $scenarioData;

	public function __construct()
    { 
		$this->scenarioData = [
			3  => [1000, 	1125],
			4  => [1500, 	1220],
			5  => [1600, 	1375],
			6  => [2400, 	1875],
			7  => [2667, 	1980],
			8  => [4000, 	2710],
			9  => [4286, 	2855],
			10 => [6250, 	3125],
			11 => [7222, 	3610],
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
			3  => [5000,	3750],
			4  => [9000,	8250],
			5  => [15000,	13130],
			6  => [23000,	20005],
			7  => [35000,	29380],
			8  => [51000,	41260],
			9  => [75000,	57520],
			10 => [105000,	77505],
			11 => [155000,	102505],
			12 => [220000,	134995],
			13 => [315000,	174995],
			14 => [445000,	231245],
			15 => [635000,	299995],
			16 => [890000,	393745],
			17 => [1300000,	512495],
			18 => [1800000,	662495],
			19 => [2550000,	856245],
			20 => [3600000,1099995]
		];
	}

	public function levelToMinXP(?int $level): int 
	{
		return $this->levelData[$level][0];
	}

	public function levelToMinGP(?int $level): int 
	{
		return $this->levelData[$level][1];
	}

	public function currentXPToLevelUp(?int $level): int {

		return $this->levelToMinXP($level+1) - $this->levelToMinXP($level);
	}

	public function levelAndXPToGV(?int $level, string $currentXp): int 
	{
		return $this->levelData[$level][1] + ($currentXp / $this->scenarioData[$level][0]) * $this->scenarioData[$level][1];
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