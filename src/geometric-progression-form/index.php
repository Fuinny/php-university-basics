Geometrinės Progresijos Lentelė
Pirmas skaičius

Daugiklis

Elementų skaičius

Stulpelių skaičius

Generuoti lentelę
"; echo ""; echo ""; echo ""; $cellSum = 0; $cellCount = 0; while ($cellCount < $numberOfElements) { if ($cellCount % $numberOfColumns == 0) { echo ""; } $currentNumber = $firstNumber * pow($multiplier, $cellCount); $cellSum += $currentNumber; echo ""; if ($cellCount % $numberOfColumns == $numberOfColumns - 1) { echo ""; } $cellCount++; } echo ""; echo "
Geometrijos Progresija
$currentNumber
Suma: $cellSum
"; echo "
"; ?>
Klaida:
	•	

Grįžtama prie numatytųjų reikšmių...
