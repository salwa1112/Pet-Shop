<?php
// all the function with SQL querries 
class ConnectionMySQL
{
    private $host = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbName = "assignment3"; //database name

    //Method to get connection from mysql
    private function getConnection()
    {
        $conn = new mysqli($this->host, $this->userName, $this->password, $this->dbName);

        //Validate if connection is wrong
        if ($conn->connect_error) {
            exit();
        }

        return $conn;
    }

    private function closeConnection($conn)
    {
        mysqli_close($conn);//Close current connection
    }

    public function loginWithUserAndPassword($userName, $password)
    {

        //get a new connection
        $conn = $this->getConnection();

        //make a query
        //select all from Username and Password columns (table users) where the user's inputs are username & password
        $query = "SELECT * FROM users WHERE Username = '{$userName}' and Password = '{$password}'";

        //Execute query
        $result = mysqli_query($conn, $query);

        $data = mysqli_fetch_row($result);

        //if user inputs are not null for username and password
        if ($data != null) {
            $user = new User(); //create a object of User class which is in models.php for the username(username input)
            $user->setId($data[0]); //set id for user in index 0
            $user->setFirstName($data[1]); //set FirstName for user in index 1
            $user->setLastName($data[2]); //set LastName for user in index 1
            $user->setEmail($data[3]); //set Email for user in index 1
            $user->setUserName($data[4]); //set UserName for user in index 4
            return $user; //return user

        } else {
            return null;
        }

        $this->closeConnection($conn); //close connection
    }

    //get the pets
    public function fetchPets()
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        // select all the columns from pets table which is sold to which customer
        $query = "SELECT p.Id,
                        p.Name,
                        p.Breed,
                        p.Photo,
                        p.Description,
                        pt.customerId
                        FROM pets p LEFT JOIN petsoldtransaction pt ON p.Id = pt.petId";
        //$query = "SELECT Id,Name,Breed,Photo,Description FROM pets";

        //Execute query
        $result = mysqli_query($conn, $query);

        //if row is greater then 0
        if ($result->num_rows > 0) {
            $petsList = new ArrayObject(); //list type of object
            while ($data = mysqli_fetch_row($result)) {
                //get all pets
                $pet = new Pet(); //object of Pet class
                $pet->setId($data[0]); //set Id to index 0
                $pet->setName($data[1]); //set Id Name index 0
                $pet->setBreed($data[2]); //set Breed to index 0
                $pet->setPhoto($data[3]); //set Photo to index 0
                $pet->setDescription($data[4]); //set description to index 0
                if($data[5]){
                    $pet->setIsSold($data[5]); //set customer ID to index 5
                }

                $petsList->append($pet); //append the petlist to the pet table
            }
            return $petsList; //return petlist
        }
        $this->closeConnection($conn);  //close connection
    }

    //get pets information by criteria
    public function fetchPetsByCriteria($value, $criteria)
    {
        //get a new connection
        $conn = $this->getConnection();
        $query = "";
        //make a query
        //if the criteria is category
        if ($criteria == "category") {
            $query = "SELECT Id,Name,Breed,Photo,Description,CategoryID FROM pets WHERE CategoryID = {$value}";
        } elseif ($criteria == "name") { //if the criteria is name
            $query = "SELECT Id,Name,Breed,Photo,Description FROM pets WHERE Name LIKE '%{$value}%'";
        }


        //Execute query
        $result = mysqli_query($conn, $query);

        //if row is greater then 0
        if ($result->num_rows > 0) {
            $petsList = new ArrayObject();
            while ($data = mysqli_fetch_row($result)) {
                //get all pets
                $pet = new Pet();
                $pet->setId($data[0]);
                $pet->setName($data[1]);
                $pet->setBreed($data[2]);
                $pet->setPhoto($data[3]);
                $pet->setDescription($data[4]);

                $petsList->append($pet);
            }
            return $petsList;
        }
        $this->closeConnection($conn);
    }

    //get categories used in edit_pet.php, home.php, new_pet.php
    public function fetchCategories()
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "SELECT Id,Name FROM categories ";

        //Execute query
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            $categoryList = new ArrayObject();
            while ($data = mysqli_fetch_row($result)) {
                //get all category
                $category = new Category(); //object of category class
                $category->setId($data[0]);
                $category->setName($data[1]);

                $categoryList->append($category);
            }
            $this->closeConnection($conn);
            return $categoryList;
        } else {
            $this->closeConnection($conn);
            return null;
        }


    }

    //function to add new pet
    public function addPet($pet)
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        //insert data into pets table;s column
        $query = "INSERT INTO pets(Name,Breed,DateBirth,Photo,Description,CategoryID) 
                    VALUES ('{$pet->getName()}','{$pet->getBreed()}','{$pet->getDateBirth()}','{$pet->getPhoto()}','{$pet->getDescription()}',{$pet->getCategory()})";

        //Execute query
        $result = mysqli_query($conn, $query);

        $this->closeConnection($conn);
        return $result;
    }

    //find pet by the ID used in edit_pet.php
    public function findPetById($petId)
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "SELECT Id,Name,Breed,DateBirth,Photo,Description,CategoryID FROM pets WHERE Id = {$petId}";

        //Execute query
        $result = mysqli_query($conn, $query);

        $data = mysqli_fetch_row($result);

        if ($result->num_rows > 0) {
            //get all pets
            $pet = new Pet();
            $pet->setId($data[0]);
            $pet->setName($data[1]);
            $pet->setBreed($data[2]);
            $pet->setDateBirth($data[3]);
            $pet->setPhoto($data[4]);
            $pet->setDescription($data[5]);
            $pet->setCategory($data[6]);
            return $pet;
        } else {
            return null;
        }
        $this->closeConnection($conn);
    }

    //update pets' information used in edit_pet.php
    public function updatePet($pet) {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        //update values in columns for pets table
        $query = "UPDATE pets SET Name='{$pet->getName()}',Breed='{$pet->getBreed()}',DateBirth='{$pet->getDateBirth()}',
                    Photo='{$pet->getPhoto()}',Description='{$pet->getDescription()}',CategoryID='{$pet->getCategory()}' WHERE Id={$pet->getId()}";

        //Execute query
        $result = mysqli_query($conn, $query);

        $this->closeConnection($conn);
        return $result;

    }

    //delete any pet
    public function deletePet($petId)
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        //delete pet
        $query = "DELETE FROM pets WHERE Id = {$petId}";

        //Execute query
        $result = mysqli_query($conn, $query);

        $this->closeConnection($conn);

        return $result;

    }

    //add new customer
    public function addCustomer($customer)
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        //insert data for new customer into customers table
        $query = "INSERT INTO customers(NAME,Address,PhoneNumber,Email) VALUES('{$customer->getName()}','{$customer->getAddress()}','{$customer->getPhoneNumber()}','{$customer->getEmail()}')";

        //Execute query
        $result = mysqli_query($conn, $query);

        $this->closeConnection($conn);
        return $result;
    }

    //get all customers information
    public function fetchAllCustomers()
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "SELECT Id,Name,Email,PhoneNumber,Address FROM customers";

        //Execute query
        $result = mysqli_query($conn, $query);


        if ($result->num_rows > 0) {
            $customersList = new ArrayObject(); //object of customertList
            //get all customers
            while ($data = mysqli_fetch_row($result)) {

                $customer = new Customer();
                $customer->setId($data[0]);
                $customer->setName($data[1]);
                $customer->setEmail($data[2]);
                $customer->setPhoneNumber($data[3]);
                $customer->setAddress($data[4]);

                $customersList->append($customer);
            }
            return $customersList;
        }
        $this->closeConnection($conn);
    }

    //find customer information by id used in edi_customer.php and sell_pet.php
    public function findCustomerById($customerId)
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "SELECT Id,Name,Email,PhoneNumber,Address FROM customers WHERE Id = {$customerId}";

        //Execute query
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_row($result);

        if ($result->num_rows > 0) {

            $customer = new Customer();
            $customer->setId($data[0]);
            $customer->setName($data[1]);
            $customer->setEmail($data[2]);
            $customer->setPhoneNumber($data[3]);
            $customer->setAddress($data[4]);

            return $customer;
        }else{
            return null;
        }
        $this->closeConnection($conn);
    }

    //update customer information
    public function updateCustomer($customer) {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "UPDATE customers SET Name='{$customer->getName()}',Email='{$customer->getEmail()}',PhoneNumber='{$customer->getPhoneNumber()}',
                    Address='{$customer->getAddress()}' WHERE Id = {$customer->getId()} ";

        echo $query."<br />";
        //Execute query
        $result = mysqli_query($conn, $query);

        $this->closeConnection($conn);
        return $result;

    }

    //delete customer
    public function deleteCustomer($customerId)
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "DELETE FROM customers WHERE Id = {$customerId}";

        //Execute query
        $result = mysqli_query($conn, $query);

        $this->closeConnection($conn);

        return $result;

    }

    //get all customers by name or email used in customers.php
    public function fetchAllCustomersByCriteria($value,$criteria)
    {
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "";
        if($criteria == 'name'){
            // if the criteria is name
            $query = "SELECT Id,Name,Email,PhoneNumber,Address FROM customers WHERE Name like '%{$value}%'";
        }elseif ($criteria == 'email'){
             // if the criteria is email
            $query = "SELECT Id,Name,Email,PhoneNumber,Address FROM customers WHERE Email like '%{$value}%'";

        }

        //Execute query
        $result = mysqli_query($conn, $query);


        if ($result->num_rows > 0) {
            $customersList = new ArrayObject();
            //get all customers
            while ($data = mysqli_fetch_row($result)) {

                $customer = new Customer();
                $customer->setId($data[0]);
                $customer->setName($data[1]);
                $customer->setEmail($data[2]);
                $customer->setPhoneNumber($data[3]);
                $customer->setAddress($data[4]);

                $customersList->append($customer);
            }
            return $customersList;
        }
        $this->closeConnection($conn);
    }
    //validate which pet is sold to which customer used in sell_pet.php
    public function validatePetIsSold($petId){
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "SELECT * FROM  petsoldtransaction pt WHERE pt.petId ={$petId}";

        //Execute query
        $result = mysqli_query($conn, $query);


        $this->closeConnection($conn);
        return $result->num_rows == 1;
    }

    // for sold out pet record for petsoldtransaction table used in sell_pet.php
    public function petSold($petId,$customerId){
        //get a new connection
        $conn = $this->getConnection();

        //make a query
        $query = "INSERT INTO petsoldtransaction(petId,customerId) VALUES({$petId},{$customerId})";

        //Execute query
        $result = mysqli_query($conn, $query);

        $this->closeConnection($conn);

        return $result;

    }
}


?>