<?php

// getters and setters for all four classes' (User, Pet, Category, Customer) variables

class User{

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $userName;
    private $password;

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function setLastName($lastName){
        $this->lastName = $lastName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setUserName($userName){
        $this->userName = $userName;
    }

    public function getUserName(){
        return $this->userName;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

}

class Pet{
    private $id;
    private $name;
    private $breed;
    private $dateBirth;
    private $photo;
    private $description;
    private $category;
    private $isSold;

    public function getId()
    {
        return $this->id;
    }

   
    public function setId($id)
    {
        $this->id = $id;
    }

   
    public function getName()
    {
        return $this->name;
    }

    
    public function setName($name)
    {
        $this->name = $name;
    }

  
    public function getBreed()
    {
        return $this->breed;
    }

    public function setBreed($breed)
    {
        $this->breed = $breed;
    }

    
    public function getDateBirth()
    {
        return $this->dateBirth;
    }

    
    public function setDateBirth($dateBirth)
    {
        $this->dateBirth = $dateBirth;
    }

  
    public function getPhoto()
    {
        return $this->photo;
    }

   
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    
    public function getDescription()
    {
        return $this->description;
    }

  
    public function setDescription($description)
    {
        $this->description = $description;
    }

   
    public function getCategory()
    {
        return $this->category;
    }

  
    public function setCategory($category)
    {
        $this->category = $category;
    }

   
    public function getIsSold()
    {
        return $this->isSold;
    }

    public function setIsSold($isSold)
    {
        $this->isSold = $isSold;
    }


}

class Category{
    private $id;
    private $name;

    
    public function getId()
    {
        return $this->id;
    }

    
    public function setId($id)
    {
        $this->id = $id;
    }

    
    public function getName()
    {
        return $this->name;
    }

   
    public function setName($name)
    {
        $this->name = $name;
    }



}

class Customer{
    private $id;
    private $name;
    private $email;
    private $phoneNumber;
    private $address;

    
    public function getId()
    {
        return $this->id;
    }

   
    public function setId($id)
    {
        $this->id = $id;
    }

    
    public function getName()
    {
        return $this->name;
    }

    
    public function setName($name)
    {
        $this->name = $name;
    }

    
    public function getEmail()
    {
        return $this->email;
    }

  
    public function setEmail($email)
    {
        $this->email = $email;
    }

    
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    
    public function getAddress()
    {
        return $this->address;
    }

    
    public function setAddress($address)
    {
        $this->address = $address;
    }
}
