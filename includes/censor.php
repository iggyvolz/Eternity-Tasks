<?php

function censorstring($string) {
	$bad_words = array(
		1 	=> 'fuck',
		2 	=> 'ass',
		3 	=> 'bitch',
		4 	=> 'cock',
		5	=> 'tits',
		6 	=> 'tities',
		7 	=> 'pussy',
		8 	=> 'dumbass',
		9 	=> 'motherfucker',
		10 	=> 'cum',
		11 	=> 'vagina',
		12 	=> 'damn',
		13 	=> 'damnit',
		14 	=> 'dammit',
		15 	=> 'boobs',
		16	=> 'boobies',
		17	=> 'horny',
		18	=> 'fucking',
		19 	=> 'seduce',
		20	=> 'sex',
		21	=> 'coitus'
	);
	
	foreach($bad_words as $censor) {
		$string = str_replace($censor, "[CENSORED]", $string);
	}
	return $string;
}
