<?php
include 'config.php';
session_start();

# admin code
if (!isset($_SESSION['aid'])) {
    header('location:login.php');
}

if (!isset($_SESSION['aid'])) {
    $_SESSION['aid'] = $_COOKIE['aid'];
}

# select data from admin table
$id = $_SESSION['aid'];
$searchTable = "SELECT * FROM admin WHERE id = $id";
$rslt = mysqli_query($conn, $searchTable);

if (!$rslt) {
    echo mysqli_error($conn);
}

$myData = mysqli_fetch_assoc($rslt);
if (!$myData) {
    echo mysqli_error($conn);
}

$welcome = "hello " . $myData['userName'] . ", Welcome!!";

# user code

# functions for set value in input field and keep checked radio button and checkbox
function setValue($value)
{
    if (isset($_POST[$value])) {
        echo $_POST[$value];
    }
}

function checked($name, $value, $show)
{
    if (isset($_POST[$name])) {
        if ($_POST[$name] == $value)
            echo  $show;
    }
}



?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap-4.6.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/CSS/style.css">
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark  ">
        <img src="./Assets/./image/ms.png" width="100px" alt="">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse h4" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active ml-4">
                    <a class="nav-link" href="addUser.php">Add Users</a>
                </li>
            </ul>

            <form class="form-inline my-2 my-lg-0" method="post">
                <div class="form-ckeck">
                    <select class="form-control" id="search_dropdown" onchange="placeholder()">
                        <option value="" selected disabled>Select filed for search</option>
                        <option value="id">Id</option>
                        <option value="firstName">First Name</option>
                        <option value="lastName">Last Name</option>
                        <option value="age">Age</option>
                        <option value="gender">Gender</option>
                        <option value="department">Department</option>
                        <option value="date_of_join">Date Of Joining</option>
                        <option value="salary">Salary</option>
                        <option value="email">Email</option>
                        <option value="hobby">Hobby</option>

                    </select>
                </div>
                <input class="form-control mr-sm-2 ml-3" type="text" id="search" placeholder="select any filed for search" disabled onkeyup="searchData()">
            </form>

            <div class="d-flex user-data ml-3">

                <img src="./assets/./image/./Admin.png" alt="Network Error" width='45px' height='45px' data-toggle="modal" data-target="#exampleModa">

                <!-- Modal -->
                <div class="modal fade " id="exampleModa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog user-info">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h2><?php echo $myData['userName']; ?></h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>


                            <div class="modal-body">
                                <h2><a href="admin_logout.php" class="btn btn-danger">Log out</a></h2>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- modal finished -->
            </div>


    </nav>



    <!--  show data of users  -->
    <div class="table-responsive ">
        <table class="table text-center">
            <thead class="thead-dark">
                <tr>

                    <th class="table-light">Id</th>
                    <th class="table-light">Fisrt Name</th>
                    <th class="table-light">Last Name</th>
                    <th class="table-light">Age</th>
                    <th class="table-light">Gender</th>
                    <th class="table-light">Department</th>
                    <th class="table-light">Date Of Join</th>
                    <th class="table-light">Salary</th>
                    <th class="table-light">Email</th>
                    <th class="table-light">Password</th>
                    <th class="table-light">Hobbies</th>
                    <th class="table-light">Photos</th>
                    <th class="table-warning">Edit</th>
                    <th class="table-danger">Delete</th>

                </tr>
            </thead>

            <tbody id="rows">
                <?php

                # fetch data from user table
                $selectTable = "SELECT * FROM user";
                $result = mysqli_query($conn, $selectTable);
                while ($myData = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="table-light"> <?php echo $myData['id']; ?> </td>
                        <td class="table-light"><?php echo $myData['firstName']; ?> </td>
                        <td class="table-light"><?php echo $myData['lastName']; ?> </td>
                        <td class="table-light"><?php echo $myData['age']; ?> </td>
                        <td class="table-light"><?php echo $myData['gender']; ?> </td>
                        <td class="table-light"><?php echo $myData['department']; ?> </td>
                        <td class="table-light"><?php echo $myData['date_of_join']; ?> </td>
                        <td class="table-light"><?php echo $myData['salary']; ?> </td>
                        <td class="table-light"><?php echo $myData['email']; ?> </td>
                        <td class="table-light"><?php echo base64_decode($myData['password']); ?> </td>
                        <td class="table-light"><?php echo $myData['hobby']; ?> </td>
                        <td class="table-light"> <img src="<?php echo $myData['photo']; ?>" alt="Network Error" hright='100px' width='100px'> </td>
                        <td class="table-warning"><a href="update.php?upld_id=<?php echo $myData['id']; ?>"><button class="btn btn-warning">Update</button></a></td>
                        <td class="table-danger"><button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">DELETE</button></td>
                        <!-- delete Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="exampleModalLabel">Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="text-dark">&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body">
                                        Do you really want to delete record?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                                        <a href="delete.php?del_id=<?php echo $myData['id']; ?>"><button class="btn btn-danger">DELETE</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </tr>
                <?php  }


                ?>

            </tbody>

        </table>
    </div>

    <script>
        let searchbar = document.getElementById("search");
        let search_drop = document.getElementById("search_dropdown");
        function placeholder() {
 

                searchbar.placeholder = 'search by ' +search_drop.value; 
                searchbar. disabled = false; 
        }

        function searchData() {
            let str = {
                srch_input: searchbar.value,
                field: search_drop.value
            }
            str = JSON.stringify(str);
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("rows").innerHTML = this.response;
                }
            }

            xhr.open("GET", "search_data.php?q=" + str, true);
            xhr.send();
        }
    </script>


    <script src="./Assets/./JS/serch.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>

</html>