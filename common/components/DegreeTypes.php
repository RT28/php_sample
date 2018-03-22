<?php
namespace common\components;

class DegreeTypes {

	const DEGREE_TYPE_UNDER_GRADUATE = 1;
	const DEGREE_TYPE_BACHELORS = 2;
	const DEGREE_TYPE_MASTERS = 3;
	const DEGREE_TYPE_DOCTORAL = 4;
	const DEGREE_TYPE_DIPLOMA = 5;

	public static $degreeTypes = [
		DegreeTypes::DEGREE_TYPE_UNDER_GRADUATE => 'Under Graduate',
		DegreeTypes::DEGREE_TYPE_BACHELORS => 'Bachelors',
		DegreeTypes::DEGREE_TYPE_MASTERS => 'Masters',
		DegreeTypes::DEGREE_TYPE_DOCTORAL => 'Doctoral',
		DegreeTypes::DEGREE_TYPE_DIPLOMA => 'Diploma',
	];
}

?>