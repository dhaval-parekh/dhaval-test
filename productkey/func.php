function recursiveRemoveDirectory($directory)
{
	foreach(glob("{$directory}/*") as $file)
	{
		if(is_dir($file)) { 
			recursiveRemoveDirectory($file);
		}else {
			echo '<pre>'; print_r($file); echo '</pre>';
			//unlink($file);
		}
	}
	//rmdir($directory);
}
recursiveRemoveDirectory(BASE_PATH);