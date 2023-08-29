<?php 

namespace AppModule\Theme\Exceptions;

class ThemeAlreadyExists extends \Exception
{
	/**
	 * @param  \AppModule\Theme\Theme  $theme
	 * @return void
	 */
	public function __construct($theme)
	{
		parent::__construct("Theme {$theme->name} already exists", 1);
	}
}