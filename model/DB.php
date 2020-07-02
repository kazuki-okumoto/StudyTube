<?php
class DB
// プロパティ
{
    private $host;
    private $dbname;
    private $lang;
    private $user;
    private $pass;
    protected $dbh;

    // コンストラクタ
    public function __construct($host, $dbname, $lang, $user, $pass)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->lang = $lang;
        $this->user = $user;
        $this->pass = $pass;
    }

    // メソッド
    public function connectDb()
    {
        $this->dbh = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=" . $this->lang, $this->user, $this->pass);
        if (!$this->dbh) {
            die('DBに接続できませんでした。');
        }
    }
}
