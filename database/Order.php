<?php

class Order {
    public $db = null;

    public function __construct(DBController $db1) {
        if (!isset($db1->con)) {
            // Холболт алга бол объект үүсгэх явцыг зогсооно
            return null;
        }
        $this->db = $db1;
    }

    // Энгийн захиалга оруулах
    public function insertOrder($item_id, $user_id) {
        if ($this->db->con != null) {
            $item_id = (int)$item_id;
            $user_id = (int)$user_id;
            $query_str = sprintf(
                "INSERT INTO `orders` (item_id, user_id) VALUES (%d, %d)",
                $item_id, $user_id
            );
            return $this->db->con->query($query_str);
        }
        return false;
    }

    // Захиалгыг устгах
    public function cancelOrder($orders_id) {
        if (isset($orders_id)) {
            $orders_id = (int)$orders_id;
            return $this->db->con->query(
                "DELETE FROM `orders` WHERE order_id={$orders_id}"
            );
        }
        return false;
    }

    // Дэлгэрэнгүй мэдээлэлтэй захиалга оруулах
    public function insertOrderWithDetails($item_id, $user_id, $phone, $address) {
        if (!empty($item_id) && !empty($user_id)) {
            $date = date("Y-m-d H:i:s");
    
            $query_string = "
                INSERT INTO `orders`
                    (`item_id`, `user_id`, `phone`, `address`, `date`)
                VALUES (?, ?, ?, ?, ?)
            ";
    
            $stmt = $this->db->con->prepare($query_string);
            $stmt->bind_param(
                "iisss",
                $item_id,
                $user_id,
                $phone,
                $address,
                $date
            );
    
            return $stmt->execute();
        }
        return false;
    }
    
    // Сагсны бүх бүтээгдэхүүнээр захиалга үүсгэх
    public function saveOrder($order_data) {
        if (isset($this->db->con)) {
            $user_id = $order_data['user_id'];
            $items = $order_data['items'];
            $items_array = json_decode($items, true);
            $result = false;
            $order_ids = [];
            
            // Холболтын алдааг нээх
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            
            // Транзакцыг эхлүүлэх
            $this->db->con->begin_transaction();
            
            try {
                // Хэрэв утасны дугаар, хаяг байхгүй бол хоосон утга өгнө
                $phone = isset($order_data['phone']) ? $order_data['phone'] : '';
                $address = isset($order_data['address']) ? $order_data['address'] : '';
                
                // Сагсны бүх бүтээгдэхүүнээр захиалга үүсгэх
                foreach ($items_array as $item) {
                    $item_id = $item['item_id'];
                    
                    // Захиалга хүснэгтэд мэдээлэл оруулах
                    $query_string = "INSERT INTO `orders` (item_id, user_id, phone, address, date, status) 
                                    VALUES (?, ?, ?, ?, NOW(), 'confirmed')";
                    
                    $stmt = $this->db->con->prepare($query_string);
                    $stmt->bind_param("iiss", $item_id, $user_id, $phone, $address);
                    $stmt->execute();
                    
                    // Захиалгын ID-г хадгалах
                    $order_ids[] = $this->db->con->insert_id;
                }
                
                // Транзакцыг баталгаажуулах
                $this->db->con->commit();
                $result = true;
            } catch (Exception $e) {
                // Алдаа гарвал транзакцыг буцаах
                $this->db->con->rollback();
                echo "Алдаа гарлаа: " . $e->getMessage();
                $result = false;
            }
            
            return $result ? $order_ids : false;
        }
        
        return false;
    }

    // Хэрэглэгчийн захиалгыг авах
    public function getUserOrders($user_id) {
        if (isset($this->db->con)) {
            $query_string = sprintf(
                "SELECT * FROM orders WHERE user_id = '%s' ORDER BY date DESC",
                mysqli_real_escape_string($this->db->con, $user_id)
            );
            
            $result = $this->db->con->query($query_string);
            $resultArray = array();
            
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }
            
            return $resultArray;
        }
        
        return [];
    }

    // Тодорхой захиалгын мэдээллийг авах
    public function getOrder($order_id) {
        if (isset($this->db->con)) {
            $query_string = sprintf(
                "SELECT * FROM orders WHERE order_id = '%s'",
                mysqli_real_escape_string($this->db->con, $order_id)
            );
            
            $result = $this->db->con->query($query_string);
            
            if ($result) {
                return mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
        }
        
        return null;
    }

    // Захиалгын төлөвийг шинэчлэх
    public function updateOrderStatus($order_id, $status) {
        if (isset($this->db->con)) {
            $query_string = sprintf(
                "UPDATE orders SET status = '%s' WHERE order_id = '%s'",
                mysqli_real_escape_string($this->db->con, $status),
                mysqli_real_escape_string($this->db->con, $order_id)
            );
            
            $result = $this->db->con->query($query_string);
            
            return $result;
        }
        
        return false;
    }
}
?>