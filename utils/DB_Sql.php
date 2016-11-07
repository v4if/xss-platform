<?php

/**
 * 获取环境变量
 * @param $key
 * @param null $default
 * @return null|string
 */
function env($key, $default = null)
{
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }
    return $value;
}

class DB
{
    protected $pdo;
    function __construct()
    {
        $serverName = env("MYSQL_PORT_3306_TCP_ADDR", "localhost");
        $serverPort = env("MYSQL_PORT_3306_TCP_PORT", "3306");
        $databaseName = env("MYSQL_INSTANCE_NAME", "homestead");
        $username = env("MYSQL_USERNAME", "homestead");
        $password = env("MYSQL_PASSWORD", "secret");

        try {
            $this->pdo = new PDO("mysql:host=".$serverName.";dbname=".$databaseName.";port=".$serverPort, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // 检测数据库是否存在表
            $isInstall = $this->pdo->query("SHOW TABLES like 'Comment';")
                ->rowCount();
            if (!$isInstall) {
                $sql = "
            CREATE TABLE Comment (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            area VARCHAR(255) NOT NULL )
            ";
                $this->pdo->exec($sql);
                $sqlData = "
        INSERT INTO `Comment` VALUES ('1', '第一条留言', 'Hello XSS');
        INSERT INTO `Comment` VALUES ('2', 'Second', 'Test');
        INSERT INTO `Comment` VALUES ('3', '我是第三条', 'Zone Open');
        ";
                $this->pdo->exec($sqlData);
            }
        } catch (PDOException $e) {
            echo "数据库链接失败: " . $e->getMessage();
            die();
        }
    }
    public function all()
    {
        return $this->pdo->query('SELECT * from Comment')
            ->fetchAll();
    }
    public function find($id)
    {
        return $this->pdo->query("SELECT * from Comment WHERE id = $id ")
            ->fetch();
    }
    public function remove($id)
    {
        return $this->pdo->exec("DELETE from Comment WHERE id = $id ");
    }
    public function add($title, $area)
    {
        $sql = "INSERT INTO Comment ( title , area ) VALUES ('$title','$area')";
        return $this->pdo->exec($sql);
    }
}
