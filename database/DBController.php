<?php
class DBController 
{
    // Өгөгдлийн сангийн холболтын тохиргоо
    protected $host = 'localhost';
    protected $user = 'root';
    protected $password = '';
    protected $database = 'watch'; // Өгөгдлийн сангийнхаа нэрийг оруулна уу

    // Холболтын хувьсагч
    public $con = null;

    // Конструктор
    public function __construct()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if ($this->con->connect_error) {
            echo "Холболт амжилтгүй болсон: " . $this->con->connect_error;
        }
    }
    
    // Деструктор
    public function __destruct()
    {
        $this->closeConnection();
    }

    // Өгөгдлийн сангийн холболтыг хаах
    protected function closeConnection()
    {
        if ($this->con != null) {
            $this->con->close();
            $this->con = null;
        }
    }

    // Запросыг ажиллуулах
    public function runQuery($query)
    {
        $result = mysqli_query($this->con, $query);
        $resultArray = array();
        
        if ($result) {
            // Үр дүнгээс өгөгдлийг массив болгон хадгалах
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }
        }
        
        return $resultArray;
    }
    
    // SQL Injection-оос хамгаалахын тулд оролтыг цэвэрлэх
    public function escapeString($str)
    {
        if ($this->con) {
            return mysqli_real_escape_string($this->con, $str);
        }
        return $str;
    }
}
?>