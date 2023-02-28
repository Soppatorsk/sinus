<?php
class Product
{
    private $categoryId;
    private $productId;
    private $description;
    private $colour;
    private $size;
    private $qty;
    private $price;
    private $name;
    
    public function __construct($categoryId, $productId, $description, $colour, $size, $qty = null, $price, $name)
    {
        $this->categoryId = $categoryId;
        $this->productId = $productId;
        $this->description = $description;
        $this->colour = $colour;
        $this->size = $size;
        $this->qty = $qty;
        $this->price = $price;
        $this->name = $name;
    }

    public function get_CategoryId()
    {
        return $this->categoryId;
    }
    public function get_ProductId()
    {
        return $this->productId;
    }
    public function get_Description()
    {
        return $this->description;
    }
    public function get_Colour()
    {
        return $this->colour;
    }
    public function get_Size()
    {
        return $this->size;
    }
    public function get_Qty()
    {
        return $this->qty;
    }
    public function get_Price()
    {
        return $this->price;
    }
    public function get_Name()
    {
        return $this->name;
    }
}

?>