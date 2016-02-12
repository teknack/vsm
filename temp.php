<?php
  include_once 'includes/db_connect.php';
  include_once 'core/stock_functions.php';

  $stockdata=getStock("core/stock.xml");
  print_r($stockdata);


Array ( 
	[0] => Array 
		( [id] => 1 [name] => StockA [code] => STK1 [parentvalue] => 200 [pointcount] => 30 [points] => Array 
			( [0] => Array 
				( [0] => 1424467068000 [1] => 244.26 ) 
			  [1] => Array 
			  	( [0] => 1424545949000 [1] => 244.26 ) 
			  [2] => Array 
			  	( [0] => 1424546276000 [1] => 246.26 ) 
			  [3] => Array ( [0] => 1424546312000 [1] => 248.26 ) [4] => Array ( [0] => 1424546314000 [1] => 250.26 ) [5] => Array ( [0] => 1424546316000 [1] => 252.26 ) [6] => Array ( [0] => 1424546328000 [1] => 254.26 ) [7] => Array ( [0] => 1424546381000 [1] => 256.26 ) [8] => Array ( [0] => 1424546383000 [1] => 258.26 ) [9] => Array ( [0] => 1424546409000 [1] => 256.26 ) [10] => Array ( [0] => 1424546412000 [1] => 254.26 ) [11] => Array ( [0] => 1424546414000 [1] => 252.26 ) [12] => Array ( [0] => 1424546415000 [1] => 250.26 ) [13] => Array ( [0] => 1424546415000 [1] => 248.26 ) [14] => Array ( [0] => 1424546416000 [1] => 246.26 ) [15] => Array ( [0] => 1424546416000 [1] => 244.26 ) [16] => Array ( [0] => 1424546481000 [1] => 242.26 ) [17] => Array ( [0] => 1424546487000 [1] => 240.26 ) [18] => Array ( [0] => 1424546560000 [1] => 238.26 ) [19] => Array ( [0] => 1424546619000 [1] => 238.56 ) [20] => Array ( [0] => 1424546689000 [1] => 242.56 ) [21] => Array ( [0] => 1425656515000 [1] => 241.56 ) [22] => Array ( [0] => 1425656576000 [1] => 242.43 ) [23] => Array ( [0] => 1425656580000 [1] => 243.33 ) [24] => Array ( [0] => 1425656584000 [1] => 244.19 ) [25] => Array ( [0] => 1425656588000 [1] => 245.13 ) [26] => Array ( [0] => 1452801135000 [1] => 245.28 ) [27] => Array ( [0] => 1452801161000 [1] => 245.21 ) [28] => Array ( [0] => 1452801302000 [1] => 245.3 ) [29] => Array ( [0] => 1452801306000 [1] => 245.13 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 245.13 ) ) [1] => Array ( [id] => 2 [name] => Stock2 [code] => STK2 [parentvalue] => 200 [pointcount] => 30 [points] => Array ( [0] => Array ( [0] => 1424189216000 [1] => 210.28 ) [1] => Array ( [0] => 1424189224000 [1] => 210.28 ) [2] => Array ( [0] => 1424189226000 [1] => 210.28 ) [3] => Array ( [0] => 1424189242000 [1] => 210.28 ) [4] => Array ( [0] => 1424198024000 [1] => 210.37 ) [5] => Array ( [0] => 1424198028000 [1] => 210.48 ) [6] => Array ( [0] => 1424198045000 [1] => 210.46 ) [7] => Array ( [0] => 1424198048000 [1] => 210.43 ) [8] => Array ( [0] => 1424198745000 [1] => 210.48 ) [9] => Array ( [0] => 1424198751000 [1] => 210.55 ) [10] => Array ( [0] => 1424198755000 [1] => 210.67 ) [11] => Array ( [0] => 1424198758000 [1] => 210.77 ) [12] => Array ( [0] => 1424199251000 [1] => 210.71 ) [13] => Array ( [0] => 1424199280000 [1] => 210.65 ) [14] => Array ( [0] => 1424199454000 [1] => 210.63 ) [15] => Array ( [0] => 1424199461000 [1] => 210.61 ) [16] => Array ( [0] => 1424209439000 [1] => 210.61 ) [17] => Array ( [0] => 1424415025000 [1] => 211.97 ) [18] => Array ( [0] => 1424415030000 [1] => 213.26 ) [19] => Array ( [0] => 1424415033000 [1] => 214.66 ) [20] => Array ( [0] => 1424415036000 [1] => 214.66 ) [21] => Array ( [0] => 1424415058000 [1] => 214.66 ) [22] => Array ( [0] => 1424415073000 [1] => 214.14 ) [23] => Array ( [0] => 1424415076000 [1] => 213.6 ) [24] => Array ( [0] => 1424415079000 [1] => 212.98 ) [25] => Array ( [0] => 1424415081000 [1] => 212.33 ) [26] => Array ( [0] => 1425563566000 [1] => 212.97 ) [27] => Array ( [0] => 1425563593000 [1] => 212.21 ) [28] => Array ( [0] => 1425563604000 [1] => 212.89 ) [29] => Array ( [0] => 1425656531000 [1] => 212.12 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 212.12 ) ) [2] => Array ( [id] => 3 [name] => Nikhileshwar Co. Ltd. [code] => NIK [parentvalue] => 100 [pointcount] => 30 [points] => Array ( [0] => Array ( [0] => 1424220344000 [1] => 105.85 ) [1] => Array ( [0] => 1424220402000 [1] => 105.85 ) [2] => Array ( [0] => 1424220419000 [1] => 105.85 ) [3] => Array ( [0] => 1424220440000 [1] => 105.85 ) [4] => Array ( [0] => 1424382240000 [1] => 105.85 ) [5] => Array ( [0] => 1424415099000 [1] => 106.09 ) [6] => Array ( [0] => 1424415110000 [1] => 106.1 ) [7] => Array ( [0] => 1424415111000 [1] => 106.11 ) [8] => Array ( [0] => 1424415111000 [1] => 106.12 ) [9] => Array ( [0] => 1424415112000 [1] => 106.13 ) [10] => Array ( [0] => 1424415113000 [1] => 106.14 ) [11] => Array ( [0] => 1424415114000 [1] => 106.15 ) [12] => Array ( [0] => 1424415115000 [1] => 106.16 ) [13] => Array ( [0] => 1424415116000 [1] => 106.17 ) [14] => Array ( [0] => 1424415117000 [1] => 106.18 ) [15] => Array ( [0] => 1424415118000 [1] => 106.19 ) [16] => Array ( [0] => 1424415125000 [1] => 106.19 ) [17] => Array ( [0] => 1424415129000 [1] => 106.17 ) [18] => Array ( [0] => 1424415130000 [1] => 106.15 ) [19] => Array ( [0] => 1424415133000 [1] => 106.13 ) [20] => Array ( [0] => 1424415135000 [1] => 106.11 ) [21] => Array ( [0] => 1424415146000 [1] => 106.09 ) [22] => Array ( [0] => 1424415151000 [1] => 106.07 ) [23] => Array ( [0] => 1424415154000 [1] => 106.05 ) [24] => Array ( [0] => 1424415156000 [1] => 106.03 ) [25] => Array ( [0] => 1424415158000 [1] => 106.01 ) [26] => Array ( [0] => 1424415160000 [1] => 106.01 ) [27] => Array ( [0] => 1424416106000 [1] => 106 ) [28] => Array ( [0] => 1424467082000 [1] => 106.29 ) [29] => Array ( [0] => 1425656519000 [1] => 105.96 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 105.96 ) ) [3] => Array ( [id] => 4 [name] => Asphalo Studios [code] => AST [parentvalue] => 350 [pointcount] => 8 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 350 ) [1] => Array ( [0] => 1424082106000 [1] => 350 ) [2] => Array ( [0] => 1424194688000 [1] => 350 ) [3] => Array ( [0] => 1424194693000 [1] => 351.68 ) [4] => Array ( [0] => 1424194700000 [1] => 350.92 ) [5] => Array ( [0] => 1424194709000 [1] => 350.92 ) [6] => Array ( [0] => 1424416799000 [1] => 353.16 ) [7] => Array ( [0] => 1424416805000 [1] => 351.88 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 351.88 ) ) [4] => Array ( [id] => 5 [name] => BoomChik Inc. [code] => BCI [parentvalue] => 150 [pointcount] => 16 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 150 ) [1] => Array ( [0] => 1424082106000 [1] => 150 ) [2] => Array ( [0] => 1424217238000 [1] => 150 ) [3] => Array ( [0] => 1424217247000 [1] => 150.02 ) [4] => Array ( [0] => 1424217280000 [1] => 150.02 ) [5] => Array ( [0] => 1424217312000 [1] => 150.01 ) [6] => Array ( [0] => 1424217325000 [1] => 150.05 ) [7] => Array ( [0] => 1424217435000 [1] => 150.04 ) [8] => Array ( [0] => 1424218462000 [1] => 150.04 ) [9] => Array ( [0] => 1424218698000 [1] => 150.04 ) [10] => Array ( [0] => 1424218757000 [1] => 150.04 ) [11] => Array ( [0] => 1424218768000 [1] => 150.04 ) [12] => Array ( [0] => 1424218958000 [1] => 150.04 ) [13] => Array ( [0] => 1424218973000 [1] => 150.03 ) [14] => Array ( [0] => 1424218988000 [1] => 150.03 ) [15] => Array ( [0] => 1424219006000 [1] => 150.03 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 150.03 ) ) [5] => Array ( [id] => 6 [name] => CompsLab8 [code] => CL8 [parentvalue] => 250 [pointcount] => 9 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 250 ) [1] => Array ( [0] => 1424082106000 [1] => 250 ) [2] => Array ( [0] => 1424168528000 [1] => 250.27 ) [3] => Array ( [0] => 1424381729000 [1] => 250.62 ) [4] => Array ( [0] => 1424416104000 [1] => 243.02 ) [5] => Array ( [0] => 1424467096000 [1] => 243.92 ) [6] => Array ( [0] => 1424547046000 [1] => 248.92 ) [7] => Array ( [0] => 1424547083000 [1] => 250.02 ) [8] => Array ( [0] => 1425656528000 [1] => 249.2 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 249.2 ) ) [6] => Array ( [id] => 7 [name] => IBM Labs [code] => IBM [parentvalue] => 175 [pointcount] => 20 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 175 ) [1] => Array ( [0] => 1424082106000 [1] => 175 ) [2] => Array ( [0] => 1424213236000 [1] => 175.01 ) [3] => Array ( [0] => 1424213245000 [1] => 175.07 ) [4] => Array ( [0] => 1424215361000 [1] => 175.07 ) [5] => Array ( [0] => 1424215376000 [1] => 175.07 ) [6] => Array ( [0] => 1424215415000 [1] => 175.07 ) [7] => Array ( [0] => 1424215427000 [1] => 175.07 ) [8] => Array ( [0] => 1424215546000 [1] => 175.07 ) [9] => Array ( [0] => 1424215684000 [1] => 175.07 ) [10] => Array ( [0] => 1424215722000 [1] => 175.07 ) [11] => Array ( [0] => 1424215725000 [1] => 175.07 ) [12] => Array ( [0] => 1424215755000 [1] => 175.02 ) [13] => Array ( [0] => 1424215885000 [1] => 175.02 ) [14] => Array ( [0] => 1424216067000 [1] => 175.02 ) [15] => Array ( [0] => 1424216074000 [1] => 174.98 ) [16] => Array ( [0] => 1424216105000 [1] => 175.03 ) [17] => Array ( [0] => 1424216893000 [1] => 175.02 ) [18] => Array ( [0] => 1424216964000 [1] => 174.99 ) [19] => Array ( [0] => 1424361434000 [1] => 174.99 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 174.99 ) ) [7] => Array ( [id] => 8 [name] => Conference Room [code] => CRM [parentvalue] => 64 [pointcount] => 30 [points] => Array ( [0] => Array ( [0] => 1424415794000 [1] => 65.08 ) [1] => Array ( [0] => 1424415801000 [1] => 65.47 ) [2] => Array ( [0] => 1424415803000 [1] => 65.33 ) [3] => Array ( [0] => 1424415809000 [1] => 65.11 ) [4] => Array ( [0] => 1424415863000 [1] => 65.11 ) [5] => Array ( [0] => 1424415865000 [1] => 65.11 ) [6] => Array ( [0] => 1424415895000 [1] => 65.11 ) [7] => Array ( [0] => 1424415975000 [1] => 65.11 ) [8] => Array ( [0] => 1424415991000 [1] => 65.11 ) [9] => Array ( [0] => 1424415994000 [1] => 65.11 ) [10] => Array ( [0] => 1424416038000 [1] => 65.11 ) [11] => Array ( [0] => 1424416041000 [1] => 65.11 ) [12] => Array ( [0] => 1424416048000 [1] => 65.29 ) [13] => Array ( [0] => 1424416053000 [1] => 65.43 ) [14] => Array ( [0] => 1424416056000 [1] => 65.56 ) [15] => Array ( [0] => 1424416059000 [1] => 65.67 ) [16] => Array ( [0] => 1424416060000 [1] => 65.78 ) [17] => Array ( [0] => 1424416063000 [1] => 65.87 ) [18] => Array ( [0] => 1424416066000 [1] => 65.95 ) [19] => Array ( [0] => 1424416068000 [1] => 66.02 ) [20] => Array ( [0] => 1424416070000 [1] => 66.09 ) [21] => Array ( [0] => 1424416144000 [1] => 65.99 ) [22] => Array ( [0] => 1424416145000 [1] => 65.86 ) [23] => Array ( [0] => 1424416146000 [1] => 65.71 ) [24] => Array ( [0] => 1424416147000 [1] => 65.55 ) [25] => Array ( [0] => 1424416148000 [1] => 65.4 ) [26] => Array ( [0] => 1424416149000 [1] => 65.21 ) [27] => Array ( [0] => 1424416149000 [1] => 65.02 ) [28] => Array ( [0] => 1424416150000 [1] => 64.8 ) [29] => Array ( [0] => 1424416152000 [1] => 64.61 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 64.61 ) ) [8] => Array ( [id] => 9 [name] => Random Stock Ltd. [code] => RSL [parentvalue] => 98 [pointcount] => 4 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 98 ) [1] => Array ( [0] => 1424082106000 [1] => 98 ) [2] => Array ( [0] => 1424382487000 [1] => 98.65 ) [3] => Array ( [0] => 1424415296000 [1] => 97.72 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 97.72 ) ) [9] => Array ( [id] => 10 [name] => Staff Room Wars [code] => SRW [parentvalue] => 166 [pointcount] => 3 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 166 ) [1] => Array ( [0] => 1424082106000 [1] => 166 ) [2] => Array ( [0] => 1424092617000 [1] => 166 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 166 ) ) [10] => Array ( [id] => 11 [name] => Out Of Ideas [code] => OOI [parentvalue] => 196 [pointcount] => 4 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 196 ) [1] => Array ( [0] => 1424082106000 [1] => 196 ) [2] => Array ( [0] => 1424182279000 [1] => 196 ) [3] => Array ( [0] => 1424196525000 [1] => 196 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 196 ) ) [11] => Array ( [id] => 12 [name] => Bleh [code] => BLH [parentvalue] => 1220 [pointcount] => 11 [points] => Array ( [0] => Array ( [0] => 1424082106000 [1] => 1220 ) [1] => Array ( [0] => 1424082106000 [1] => 1220 ) [2] => Array ( [0] => 1424082682000 [1] => 1220 ) [3] => Array ( [0] => 1424082695000 [1] => 1220 ) [4] => Array ( [0] => 1424082701000 [1] => 1219.8 ) [5] => Array ( [0] => 1424190864000 [1] => 1219.8 ) [6] => Array ( [0] => 1424190953000 [1] => 1219.8 ) [7] => Array ( [0] => 1424190978000 [1] => 1219.8 ) [8] => Array ( [0] => 1424376619000 [1] => 1179.67 ) [9] => Array ( [0] => 1424416084000 [1] => 1183.33 ) [10] => Array ( [0] => 1424416153000 [1] => 1179.3 ) ) [latest] => Array ( [0] => 1453871364000 [1] => 1179.3 ) ) ) 

?>


