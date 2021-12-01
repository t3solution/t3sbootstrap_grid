<?php
namespace T3S\T3sbootstrapGrid\DisplayCond;

class Cond{

public function useGridField($arguments): bool
{
	if ( $arguments['record']['CType'][0] == 'two_columns'
	 || $arguments['record']['CType'][0] == 'three_columns'
	 || $arguments['record']['CType'][0] == 'four_columns'
	 || $arguments['record']['CType'][0] == 'six_columns'
	 || $arguments['record']['CType'][0] == 'row_columns' ) {
		return true;
	}

	return false;
	}
}
