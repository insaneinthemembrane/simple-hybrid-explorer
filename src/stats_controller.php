<?php
/*
Need address search
 
*/
/*

PoS 24hr

*/

/*Iheart Comment: Note that the RPC interface is not able to achieve all of the stats. An SQL database to parse the blockchain:
http://github.com/snakie/blockparser could be used
*/

require_once ("src/fetish_daemon.php");
require_once ("src/fetish_layout.php");

	/**
	* Get the number of pos block in the last @param hours
	*
	* @param	int	$hours
	*
	* @return	int
	*/
	function get_num_pos($hours) 
	{
		$network_info = getinfo ();

		$currentblock = $network_info["blocks"];
		
		$iblock = intval($currentblock) - 6*$hours;
		
		$POScoins = 0;
		$POWcoins = 0;
		$POS = 0;
                $POW = 0;
                $avgPOScoins = 0;
                $avgPOWcoins = 0;
                $avgPOScoins = 0;
                $avgPOWcoins = 0;
		while ($iblock != intval($currentblock))
		{
			$flag = block_flag($iblock);
			$coins = block_mint($iblock);
			if (strpos($flag ,"proof-of-stake") !== false)
			{
				$POS++;
				$POScoins += $coins;
			}
			else {
                                $POW++;
				$POWcoins += $coins;
			}
			$iblock++;
		}
                if ($POS > 0)
                    $avgPOScoins = $POScoins / $POS;
                if ($POW > 0)
                    $avgPOWcoins = $POWcoins / $POW;

                return array($POS, $POW, $POScoins, $POWcoins, $avgPOScoins, $avgPOWcoins);
	}
	
	//Find the flag for a block
	
	function block_flag($block_id)
	{
		$block_hash = getblockhash($block_id);
		$raw_block = getblock($block_hash);
		$flags = $raw_block["flags"];
		return $flags;
	}
	
	// Find the minted or mined coins
	function block_mint($block_id)
	{
		$block_hash = getblockhash($block_id);
		$raw_block = getblock($block_hash);
		$mint = $raw_block["mint"];
		return $mint;
	}
	
		function ratio($a, $b) {
    $_a = $a;
    $_b = $b;

    while ($_b != 0) {

        $remainder = $_a % $_b;
        $_a = $_b;
        $_b = $remainder;   
    }

    $gcd = abs($_a);

    return ($a / $gcd)  . ':' . ($b / $gcd);

}
?>
