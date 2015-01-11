<?php

/**
 * Class Init
 * Checks and creates gitignore files
 */
class Init
{
    /**
     * @var string Name of database
     */
    private $dbname = null;

    /**
     * @var string MySql hostname
     */
    private $host = null;

    /**
     * @var string MySql username
     */
    private $username = null;

    /**
     * @var string MySql user password
     */
    private $password = null;

    /**
     * @var string Yii framework path
     */
    private $framework = null;

    /**
     * @var array Files templates
     */
    private $filesTemplates = array(
        'local' => '/protected/config/local.php',
        'index' => '/www/index.php',
        'yiic' => '/protected/yiic.php',
        'robots' => '/www/robots.txt',
    );

    /**
     * Shows error message
     *
     * @param string $msg
     */
    private function error($msg)
    {
        exit("Init::Error: " . $msg . "\n");
    }

    /**
     * Shows info message
     *
     * @param string $msg
     * @param string $end
     */
    private function msg($msg, $end = "\n")
    {
        echo $msg . $end;
    }

    /**
     * Read console input string
     *
     * @return string
     */
    private function readLine()
    {
        return trim(fgets(STDIN));
    }

    /**
     * Read console input and save to class property if exists
     *
     * @param string $name Property name
     * @param string $msg
     */
    private function readParam($name, $msg)
    {
        if (property_exists($this, $name))
        {
            $this->msg($msg);
            $this->{$name} = $this->readLine();
        }
        else
            $this->error("Property `{$name}` not found.");
    }

    /**
     * Shows confirmation
     *
     * @param $msg
     *
     * @return bool
     */
    private function confirm($msg)
    {
        $this->msg($msg, null);
        return (in_array($this->readline(), array('y', 'yes')));
    }

    /**
     * Returns file template content
     *
     * @param string $name
     *
     * @return null|string
     */
    private function getFileTemplate($name)
    {
        $result = null;
        switch ($name)
        {
            case 'local':
                $result = "<?php
return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host={$this->host};dbname={$this->dbname}',
            'emulatePrepare' => true,
            'username' => '{$this->username}',
            'password' => '{$this->password}',
            'charset' => 'utf8',
        ),
    ),
	'modules' => array(
		// uncomment the following to enable the Gii tool
		/*'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => '123456',
			'ipFilters' => array('*'),
		),*/
	),
);
?>";
                break;
            case 'index':
                $result = "<?php
\$yii = dirname(__FILE__) . '{$this->framework}/yii.php';
\$config = dirname(__FILE__) . '/../protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once(\$yii);
Yii::createWebApplication(\$config)->runBranch();
?>";
                break;
            case 'yiic':
                $result = "<?php
\$yiic = dirname(__FILE__) . '{$this->framework}/yiic.php';
\$config = dirname(__FILE__) . '/config/console.php';

require_once(\$yiic);
?>";
                break;
            case 'robots':
                $result = "User-agent: *
Disallow: /";
                break;
        }

        return $result;
    }

    /**
     * Checks MySql connect
     */
    private function checkDbConnect()
    {
        if ($link = @mysql_connect($this->host, $this->username, $this->password))
        {
            $this->msg('Successfully connected to MySql.');
            if (@mysql_select_db($this->dbname, $link))
                $this->msg("Database `{$this->dbname}` exists.");
            else
                $this->error("Database `{$this->dbname}` not found.");

            @mysql_close($link);
        }
        else
            $this->error('Could not connect to MySql.');
    }

    /**
     * Creates directory
     *
     * @param string $path
     */
    private function createDirectory($path)
    {
        if (mkdir($path))
            $this->msg("Successfully created directory `{$path}`.");
        else
            $this->error("Can not create directory `{$path}`.");
    }

    /**
     * Changes directory permissions
     *
     * @param string $path
     * @param integer $mode
     */
    private function changeAccess($path, $mode = 755)
    {
        $this->checkDirectory($path);
        if (chmod($path, octdec($mode)))
            $this->msg("Successfully changed permissions for `{$path}` to `{$mode}`.");
        else
            $this->error("Can not change permissions for `{$path}` to `{$mode}`.");

    }

    /**
     * Checks directory
     *
     * @param $path
     */
    private function checkDirectory($path)
    {
        if (!file_exists($path) and $this->confirm("Directory `{$path}` not found. Create directory ? (yes|no) [no]: "))
            $this->createDirectory($path);
    }

    /**
     * Creates new file
     *
     * @param $filepath
     * @param $filename
     * @param $data
     */
    private function createFile($filepath, $filename, $data)
    {
        $this->checkDirectory($filepath);
        $this->changeAccess($filepath, 777);
        if (file_put_contents($filepath . $filename, $data))
            $this->msg("Successfully create `{$filepath}{$filename}`.");
        else
            $this->error("Can not create `{$filepath}{$filename}`.");

        $this->changeAccess($filepath);
    }

    /**
     * Checks framework directory
     */
    private function checkFramework()
    {
        if (file_exists(__DIR__ . $this->framework))
            $this->msg("Framework directory `{$this->framework}` exists.");
        else
            $this->error("Framework directory `{$this->framework}` not found.");
    }

    /**
     * Run patching
     */
    public function run()
    {
        // writable directories
        if ($this->confirm("Change permissions for `/www/assets`, `/www/upload`, `/protected/runtime`? (yes|no) [no]: "))
        {
            $this->changeAccess(__DIR__ . "/www/assets/", 777);
            $this->changeAccess(__DIR__ . "/www/upload/", 777);
            $this->changeAccess(__DIR__ . "/protected/runtime/", 777);
        }

        //local.php
        if ($this->confirm("Create db config file `/protected/config/local.php`? (yes|no) [no]: "))
        {
            $this->readParam('host', 'Enter a MySql hostname: ');
            $this->readParam('username', 'Enter a MySql username: ');
            $this->readParam('password', 'Enter a MySql password: ');
            $this->readParam('dbname', 'Enter a Database name: ');
            $this->checkDbConnect();
            $this->createFile(__DIR__ . '/protected/config/', 'local.php', $this->getFileTemplate('local'));
        }

        //robots.txt
        if ($this->confirm("Create `/www/robots.txt`? (yes|no) [no]:"))
            $this->createFile(__DIR__ . '/www/', 'robots.txt', $this->getFileTemplate('robots'));


        //index.php, yiic.php
        if ($this->confirm("Create files relates from framework path `/www/index.php`, `/protected/yiic.php`? (yes|no) [no]: "))
        {
            $this->readParam('framework', 'Enter a path to framework relatively project root (example, `/../../framework`): ');
            $this->checkFramework();
            $this->createFile(__DIR__ . '/www/', 'index.php', $this->getFileTemplate('index'));
            $this->createFile(__DIR__ . '/protected/', 'yiic.php', $this->getFileTemplate('yiic'));
        }
    }
}

$init  = new Init();
$init->run();