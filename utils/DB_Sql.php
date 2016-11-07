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
            $isInstall = $this->pdo->query("SHOW TABLES like 'users';")
                ->rowCount();
            if (!$isInstall) {
                $sql = "
            CREATE TABLE users (
            user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL )
            ";
                $this->pdo->exec($sql);
                $sqlData = "
        INSERT INTO `users` VALUES ('1', 'admin', 'admin');
        INSERT INTO `users` VALUES ('2', 'Gordon', 'Brown');
        INSERT INTO `users` VALUES ('3', 'Hack', 'Me');
        INSERT INTO `users` VALUES ('4', 'chao', 'yang');
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
        return $this->pdo->query('SELECT * from users')
            ->fetchAll();
    }
    public function find($user_id)
    {
        return $this->pdo->query("SELECT * from users WHERE user_id = $user_id ")
            ->fetch();
    }
    public function remove($user_id)
    {
        return $this->pdo->exec("DELETE from users WHERE user_id = $user_id ");
    }
    public function add($first_name, $last_name)
    {
        $sql = "INSERT INTO users ( first_name , last_name ) VALUES ('$first_name','$last_name')";
        return $this->pdo->exec($sql);
    }
}
