<?php
class Product {
    public $db = null;

    public function __construct(DBController $db1) {
        if (!isset($db1->con)) return null;
        $this->db = $db1;
    }

    // fetch all products
    public function getData($table = "product") {
        $result = $this->db->con->query("SELECT * FROM `{$table}`");
        $resArray = array();
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resArray[] = $item;
        }
        return $resArray;
    }

    // fetch products by "Place"
    public function getDataFeatured($table = "product", $place = "featured") {
        $stmt = $this->db->con->prepare("SELECT * FROM {$table} WHERE Place = ?");
        $stmt->bind_param("s", $place);
        $stmt->execute();
        $result = $stmt->get_result();
        $resArray = array();
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resArray[] = $item;
        }
        $stmt->close();
        return $resArray;
    }

    // fetch by place + subject
    public function getDataSpecific($table = "product", $place, $subject) {
        $stmt = $this->db->con->prepare("SELECT * FROM {$table} WHERE Place = ? AND subject = ?");
        $stmt->bind_param("ss", $place, $subject);
        $stmt->execute();
        $result = $stmt->get_result();
        $resArray = array();
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resArray[] = $item;
        }
        $stmt->close();
        return $resArray;
    }

    // get one product by id
    public function getProduct($item_id = null, $table = 'product') {
        if (isset($item_id)) {
            $stmt = $this->db->con->prepare("SELECT * FROM {$table} WHERE item_id = ?");
            $stmt->bind_param("i", $item_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $resArray = array();
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resArray[] = $item;
            }
            $stmt->close();
            return $resArray;
        }
    }

    // insert product
    public function insertProduct($brand, $name, $price, $image, $subject) {
        if ($this->db->con != null) {
            try {
                $stmt = $this->db->con->prepare("INSERT INTO `product` (item_brand, item_name, item_price, item_image, subject) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdss", $brand, $name, $price, $image, $subject);
                $result = $stmt->execute();
                $stmt->close();
                return $result;
            } catch (Exception $e) {
                echo "Exception: " . $e->getMessage();
            }
        }
        return false;
    }

    // update product
    public function updateProduct($item_id, $productBrand, $productName, $productPrice, $image_path, $productSize, $productDescription) {
        $sql = "UPDATE product SET item_brand = ?, item_name = ?, item_price = ?, item_image = ?, subject = ?, item_description = ? WHERE item_id = ?";
        $stmt = $this->db->con->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $this->db->con->error);
        }
        $stmt->bind_param("ssdsssi", $productBrand, $productName, $productPrice, $image_path, $productSize, $productDescription, $item_id);
        $result = $stmt->execute();
        if ($result === false) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
        return $result;
    }

    // delete product
    public function deleteProduct($item_id) {
        if (isset($item_id)) {
            $stmt = $this->db->con->prepare("DELETE FROM product WHERE item_id = ?");
            if (!$stmt) throw new Exception("Prepare failed: " . $this->db->con->error);
            $stmt->bind_param("i", $item_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
            /**
         * Захиалгын төлөвийг шинэчлэх функц
         * 
         * @param int $order_id Захиалгын дугаар
         * @return bool Амжилттай/амжилтгүй үйлдлийн үр дүн
         */
        public function checkOrder($order_id) {
            try {
                // Захиалгын бүртгэлд "checked" талбарын утгыг шинэчлэх
                $query = "UPDATE orders SET checked = 1 WHERE order_id = ?";
                
                // SQL запрос гүйцэтгэх
                $stmt = $this->db->con->prepare($query);
                $stmt->bind_param('i', $order_id);
                $result = $stmt->execute();
                $stmt->close();
                
                return $result;
            } catch (Exception $e) {
                // Алдааг логдох эсвэл дамжуулах
                throw new Exception("Захиалгын төлөв шинэчлэхэд алдаа гарлаа: " . $e->getMessage());
            }
        }
    
}
?>
