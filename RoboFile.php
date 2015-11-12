<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    // define public methods as commands
    function watchComposer()
    {
        // when composer.json changes `composer update` will be executed
        $this->taskWatch()->monitor('composer.json', function() {
            $this->taskComposerUpdate()->run();
        })->monitor('public/scss/layout.scss', function() {
		     $this->assets();
		})->run();
    }

    /**
	 * Minify assets
	 */
	function assets() 
	{
		$this->taskScss([
		    'public/scss/layout.scss' => 'public/css/style.css'
		])
		->importDir('public/css')
		->run();

		$this->taskMinify('public/css/style.css')
        ->to('public/css/style.min.css')
        ->run();
	}
}