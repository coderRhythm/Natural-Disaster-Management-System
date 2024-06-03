<?php

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $database = "disaster_management";


        // connections
        $conn = mysqli_connect($servername, $username,$password,$database);

        // insert to the database
        // $sql  = "create table `disaster_form` (
        //             `id` int primary key auto_increment,
        //             `email` varchar(255) not null,
        //             `password` varchar(255) not null,
        //             `latitude` decimal(10,8) not null,
        //             `longitude` decimal(11,8) not null
        // );
        //         ";

        // $result = mysqli_query($conn,$sql);
        
        // query for inserting the value 
        
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT); // Hash the password

            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];


            // check if the user allow for location or not 
            if($latitude==NULL || $longitude==NULL)
            {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>WARNING!</strong> Plz click on the allow button 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
            else{
                

                // inserting to the table 
                $sql1 = "insert into `disaster_form`(`email`,`password`,`latitude`,`longitude`) values('$email','$hashed_password','$latitude','$longitude')";
    
                $result1 = mysqli_query($conn,$sql1); 

                if ($result1) {
                    // Redirect user to disaster.html
                    header("Location: disaster.html");
                    exit(); // Ensure no further code is executed
                } else {
                    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                }
               
            }


        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   
    <title>Document</title>
    <script>
        const x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;
}
    </script>
</head>
<body>
<div class="container my-4">
    <h1>Welcome to the disaster management system</h1>
    <div class="p-4 border">
        <form action="disaster.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="category">Select the disaster: </label>
                <select class="form-control" id="category" name = "category">
                    <option>Earthquake</option>
                    <option>Flooding</option>
                    <option>Cyclones</option>
                    <option>Avalanches</option>
                    <option>snowStorms</option>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <button type="button" class="btn btn-secondary" onclick="getLocation()">Allow Location</button>
            </div>
            
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
    const latitudeInput = document.getElementById("latitude");
    const longitudeInput = document.getElementById("longitude");

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else { 
        alert("Geolocation is not supported by this browser.");
      }
    }

    function showPosition(position) {
      latitudeInput.value = position.coords.latitude;
      longitudeInput.value = position.coords.longitude;
    }

    function showError(error) {
      switch(error.code) {
        case error.PERMISSION_DENIED:
          alert("User denied the request for Geolocation.");
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }
    </script>
  </body>
</html>