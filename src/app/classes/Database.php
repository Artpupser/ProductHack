<?php
require_once "./app/utils/env.php";

class Database {
    //fields
    private $host;
    private $name;
    private $pass;
    private $user;
    private $connection;

    //constructor
    public function __construct() {
        load_env();
        $this->name = $_ENV["DB_HOST"];
        $this->name = $_ENV["DB_NAME"];
        $this->pass = $_ENV["DB_PASS"];
        $this->user = $_ENV["DB_USER"];
    }


    //funcs
    public function buildConnectionStr(): string {
        return "host=" . $this->host . " dbname=" . $this->name . " user=" . $this->user . " password=" . $this->pass;
    }

    public function connect() {
        try {
            $this->connection = pg_connect($this->buildConnectionStr(), 0);
            if(pg_connection_status($this->connection) === PGSQL_CONNECTION_OK) {
                server_log("Database connection success!");
            }
            server_error("Database bad connection!");
        } catch (\Throwable $th) {
            server_error("Carch error, database wrong connection!");
        }

    }

    public function dbQueryGet(string $query): array {
        return pg_fetch_all(pg_query($this->connection, $query));
    }
}
?>