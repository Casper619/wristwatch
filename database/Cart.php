<?php 
class Cart {
    public $db = null;
    
    public function __construct(DBController $db) {
        if (!isset($db->con)) return null;
        $this->db = $db;
    }

    public function insertIntoCart($params = null, $table = 'cart') {
        if ($this->db->con != null) {
            if ($params != null) {
                // cart_id баганыг хассан
                $cols = implode(',', array_keys($params));
                $vals = array_map(function ($value) {
                    return is_numeric($value) ? $value : "'$value'";
                }, array_values($params));
                $vals_str = implode(',', $vals);
                
                $query_str = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $cols, $vals_str);
                
                return $this->db->con->query($query_str);
            }
        }
    }
     
    // To get user_id and item_id into cart table
    public function addToCart($userid, $itemid) {
        if (!empty($userid) && !empty($itemid)) {  // User ID хоосон биш байхыг шалгах
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid
            );
            
            $result = $this->insertIntoCart($params);
            if ($result) {
                // Хуудас дахин ачаалах тухай мэдээллийг буцаа, гэхдээ header() хэрэглэлгүйгээр
                return [
                    'status' => 'success',
                    'message' => 'Бүтээгдэхүүн сагсанд нэмэгдлээ!'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => '⚠️ Error: User ID or Item ID is missing!'
            ];
        }
    }
    
    public function getSum($arr) {
        if (isset($arr)) {
            $sum = 0;
            foreach ($arr as $item) {
                $sum += $item[0];
            }
            return $sum;
        }
        return 0;
    }
    
    public function deleteProduct($cart_id) {
        if (isset($cart_id)) {
            $res = $this->db->con->query("DELETE FROM `cart` WHERE item_id = {$cart_id};");
            return $res;
        }
    }
}