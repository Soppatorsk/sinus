<?php
class Order
{
    private $orderDate;
    private $firstName;
    private $lastName;
    private $productName;
    private $colour;
    private $qty;
    private $price;
    private $size;
    private $totalPrice;
    
    public function __construct($orderDate, $firstName, $lastName, $productName, $colour, $qty, $price, $size, $totalPrice)
    {
        $this->orderDate = $orderDate;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->productName = $productName;
        $this->colour = $colour;
        $this->qty = $qty;
        $this->price = $price;
        $this->size = $size;
        $this->totalPrice = $totalPrice;
    }

    public function get_OrderDate()
    {
        return $this->orderDate;
    }
    public function get_FirstName()
    {
        return $this->firstName;
    }
    public function get_LastName()
    {
        return $this->lastName;
    }
    public function get_ProductName()
    {
        return $this->productName;
    }
    public function get_Colour()
    {
        return $this->colour;
    }
    public function get_Qty()
    {
        return $this->qty;
    }
    public function get_Price()
    {
        return $this->price;
    }
    public function get_Size()
    {
        return $this->size;
    }
    public function get_TotalPrice()
    {
        return $this->totalPrice;
    }
}